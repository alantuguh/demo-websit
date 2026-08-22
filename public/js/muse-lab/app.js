/*
 * Muse Lab — orkestrator halaman monitor (/muse-lab).
 *
 * Dimuat sebagai <script type="module">. Mengandalkan tiga global yang
 * dimuat lebih dulu lewat <script> klasik: MuseDSP, MuseMetrics, MuseCharts.
 * muse-js diimpor dinamis dari CDN ESM (jsDelivr, fallback esm.sh) — hanya
 * saat pengguna menekan "Hubungkan", jadi Mode Demo tetap jalan offline
 * ataupun di browser tanpa Web Bluetooth.
 *
 * Fakta muse-jsx 0.3.1 yang dipakai di sini (diverifikasi dari source):
 *  - MuseClient (klasik: Muse 1/2/S lama): EEG 256 Hz, paket 12 sampel per
 *    elektroda dalam µV; electrode 0..4 → channelNames; enableAux/enablePpg
 *    WAJIB sebelum connect(); observable baru ada setelah connect();
 *    PPG 64 Hz 3 kanal; accelerometer paket 3 sampel {x,y,z} dalam g.
 *  - MuseAthenaClient (Muse S Athena): karakteristik multiplex 273e0013;
 *    eegReadings bentuknya sama (skala 14-bit 0.0885 µV/LSB sudah benar di
 *    muse-jsx); accGyroReadings satu sampel per emisi; opticalReadings
 *    64 Hz menggantikan PPG; batteryData terpisah; start(preset).
 *  - Kedua protokol dibedakan lewat ENUMERASI characteristic, bukan nama
 *    perangkat (Athena juga bernama "MuseS-XXXX").
 *  - requestDevice() harus dipanggil dari gestur pengguna (klik).
 */
'use strict';

const DSP = window.MuseDSP;
const MET = window.MuseMetrics;
const CH = window.MuseCharts;

const FS_EEG = 256;
const FS_PPG = 64;
const KANAL = ['TP9', 'AF7', 'AF8', 'TP10'];

// muse-jsx = fork muse-js yang menambah dukungan Muse S Athena
// (MuseAthenaClient, protokol multiplex 273e0013) di samping MuseClient
// klasik untuk Muse 1/2/S lama. muse-js asli TIDAK bisa konek ke Athena.
const CDN_UTAMA = 'https://cdn.jsdelivr.net/npm/muse-jsx@0.3.1/+esm';
const CDN_CADANGAN = 'https://esm.sh/muse-jsx@0.3.1';

const MUSE_SERVICE = 0xfe8d;
const UUID_ATHENA_DATA = '273e0013-4c4d-454d-96be-f03bac821358';
const UUID_PPG_1 = '273e000f-4c4d-454d-96be-f03bac821358';

const KUNCI_BASELINE = 'muse-lab-baseline-v1';

const $ = (id) => document.getElementById(id);

/* =====================================================================
 * State global halaman
 * =================================================================== */
const state = {
    mode: null,           // null | 'muse' | 'demo'
    client: null,         // instance MuseClient
    langganan: [],        // subscription rxjs untuk dibersihkan
    demoTimer: [],
    kanal: {},            // per kanal: {ring, chain, kualitas, paketTerakhir}
    postur: new MET.PosturKepala(),
    kedip: new MET.DeteksiKedip(FS_EEG),
    jantung: new MET.EstimasiJantung(FS_PPG),
    ppgChain: null,
    ppgAda: false,
    indeks: { bebanKerja: null, kelelahan: null, fokus: null, relaksasi: null },
    kategori: {},
    histeresis: {},
    baseline: null,
    kalibrasi: null,      // {sisa, sampel:{...}} saat kalibrasi berjalan
    perekam: new MET.PerekamSesi(),
    bandTerakhir: null,   // band power rata frontal utk spektrum
    grafik: {},
};

for (const nama of MET.NAMA_INDEKS) {
    state.histeresis[nama] = new MET.KategoriHisteresis(nama);
    state.kategori[nama] = null;
}

function resetKanal() {
    for (const k of KANAL) {
        state.kanal[k] = {
            ring: new DSP.RingBuffer(FS_EEG * 10),
            chain: DSP.makeEegFilterChain(FS_EEG),
            kualitas: 'putus',
            paketTerakhir: 0,
        };
    }
    state.postur = new MET.PosturKepala();
    state.kedip = new MET.DeteksiKedip(FS_EEG);
    state.jantung = new MET.EstimasiJantung(FS_PPG);
    state.ppgChain = null;
    state.ppgAda = false;
}
resetKanal();

/* =====================================================================
 * Muat baseline tersimpan
 * =================================================================== */
try {
    const tersimpan = JSON.parse(localStorage.getItem(KUNCI_BASELINE) || 'null');
    if (tersimpan && tersimpan.indeks) state.baseline = tersimpan;
} catch (e) { /* abaikan baseline korup */ }

/* =====================================================================
 * Penerima data — dipakai BAIK oleh muse-js maupun mode demo
 * =================================================================== */
function terimaEeg(namaKanal, samples) {
    const k = state.kanal[namaKanal];
    if (!k) return;
    k.paketTerakhir = performance.now();
    for (const s of samples) {
        const bersih = k.chain.process(s);
        k.ring.push(bersih);
        if (namaKanal === 'AF7') state.kedip.proses(bersih);
    }
}

function terimaAccel(samples) {
    for (const s of samples) state.postur.update(s);
}

function terimaPpg(samples) {
    if (!state.ppgChain) {
        // band-pass 0.7–3.5 Hz (42–210 bpm): buang DC 24-bit + noise tinggi
        const hp = DSP.Biquad.highpass(FS_PPG, 0.7, 0.707);
        const lp = DSP.Biquad.lowpass(FS_PPG, 3.5, 0.707);
        state.ppgChain = { process: (x) => lp.process(hp.process(x)) };
    }
    state.ppgAda = true;
    for (const s of samples) state.jantung.proses(state.ppgChain.process(s));
}

function terimaBaterai(persen) {
    $('info-baterai').textContent = Math.round(persen) + '%';
    $('chip-baterai').style.display = '';
}

/* =====================================================================
 * Koneksi Muse sungguhan (muse-js via CDN)
 * =================================================================== */
async function muatMuseJs() {
    try {
        return await import(CDN_UTAMA);
    } catch (e) {
        console.warn('CDN utama gagal, coba cadangan:', e);
        return await import(CDN_CADANGAN);
    }
}

async function hubungkanMuse() {
    if (!navigator.bluetooth) {
        tampilkanGalat('Browser ini tidak mendukung Web Bluetooth. Pakai Chrome/Edge di desktop atau Android — atau coba Mode Demo.');
        return;
    }
    setStatus('menghubungkan', 'Menghubungkan…');
    try {
        // requestDevice HARUS tetap di rantai gestur pengguna; muatan modul
        // CDN dilakukan sesudahnya (import() tidak memutus gestur, tapi kalau
        // jaringan lambat lebih aman meminta izin perangkat dulu).
        const device = await navigator.bluetooth.requestDevice({
            filters: [{ services: [MUSE_SERVICE] }],
            optionalServices: [MUSE_SERVICE],
        });
        const gatt = await device.gatt.connect();
        const service = await gatt.getPrimaryService(MUSE_SERVICE);

        // Deteksi protokol yang ANDAL: enumerasi characteristic.
        // Nama perangkat tidak bisa dipakai — Athena juga beriklan "MuseS-XXXX".
        const daftarChar = await service.getCharacteristics();
        const uuids = new Set(daftarChar.map((c) => c.uuid.toLowerCase()));
        const adalahAthena = uuids.has(UUID_ATHENA_DATA);
        const adaPpgKlasik = uuids.has(UUID_PPG_1);

        const muse = await muatMuseJs();

        hentikanSemua(false);
        resetKanal();
        state.mode = 'muse';

        if (adalahAthena) {
            await hubungkanAthena(muse, gatt);
        } else {
            await hubungkanKlasik(muse, gatt, adaPpgKlasik);
        }

        const namaPerangkat = (state.client && state.client.deviceName) || device.name || 'Muse';
        $('info-perangkat').textContent = namaPerangkat + (adalahAthena ? ' (Athena)' : '');
        setStatus('terhubung', 'Terhubung — ' + namaPerangkat + (adalahAthena ? ' · protokol Athena' : ''));
        aturTombol(true);

        // Penjaga aliran: koneksi GATT bisa sukses tapi streaming ditolak
        // (kasus khas Athena: rc:69 karena aplikasi Muse resmi masih
        // memegang perangkat). Kalau 8 detik tanpa satu pun paket EEG,
        // beri tahu penyebab yang paling mungkin.
        setTimeout(() => {
            if (state.mode === 'muse'
                && KANAL.every((n) => state.kanal[n].paketTerakhir === 0)) {
                tampilkanGalat('Terhubung tetapi tidak ada data masuk. Tutup TOTAL aplikasi Muse/Mind Monitor di HP (Athena hanya menerima satu koneksi), matikan Bluetooth HP, lalu coba lagi.');
            }
        }, 8000);
    } catch (e) {
        console.error(e);
        state.mode = null;
        if (e && (e.name === 'NotFoundError' || String(e).includes('User cancelled'))) {
            setStatus('siap', 'Pemilihan perangkat dibatalkan');
        } else {
            tampilkanGalat('Gagal terhubung: ' + (e.message || e) + '. Pastikan headband menyala dan tidak sedang dipakai aplikasi lain.');
            setStatus('siap', 'Belum terhubung');
        }
    }
}

/** Muse 1 / Muse 2 / Muse S lama — MuseClient klasik (API muse-js). */
async function hubungkanKlasik(muse, gatt, adaPpg) {
    const client = new muse.MuseClient();
    // enablePpg wajib di-set SEBELUM connect(). Muse 1/2016 tidak punya
    // characteristic PPG — flag hanya dinyalakan bila char-nya memang ada.
    client.enablePpg = adaPpg;
    await client.connect(gatt);
    state.client = client;

    state.langganan.push(client.eegReadings.subscribe((r) => {
        const nama = muse.channelNames[r.electrode];
        if (KANAL.includes(nama)) terimaEeg(nama, r.samples);
    }));
    state.langganan.push(client.telemetryData.subscribe((t) => terimaBaterai(t.batteryLevel)));
    state.langganan.push(client.accelerometerData.subscribe((a) => terimaAccel(a.samples)));

    if (adaPpg && client.ppgReadings) {
        // Pemetaan kanal inframerah berbeda antar model (README muse-js):
        // Muse 2: [ambient, infrared, red] → indeks 1;
        // Muse S lama: [infrared, green, ?] → indeks 0.
        const kanalIr = (client.deviceName || '').startsWith('MuseS') ? 0 : 1;
        state.langganan.push(client.ppgReadings.subscribe((p) => {
            if (p.ppgChannel === kanalIr) terimaPpg(p.samples);
        }));
    }

    state.langganan.push(client.connectionStatus.subscribe((tersambung) => {
        if (!tersambung && state.mode === 'muse') {
            setStatus('putus', 'Koneksi terputus');
            hentikanSemua(true);
        }
    }));

    await client.start();
}

/** Muse S Athena — MuseAthenaClient (protokol multiplex 273e0013). */
async function hubungkanAthena(muse, gatt) {
    const client = new muse.MuseAthenaClient();
    await client.connect(gatt);
    state.client = client;

    // Bentuk EEGReading Athena sama dengan klasik: {electrode, samples[]};
    // 4 kanal pertama = TP9, AF7, AF8, TP10 (athenaChannelNames).
    const namaKanal = muse.athenaChannelNames || KANAL;
    state.langganan.push(client.eegReadings.subscribe((r) => {
        const nama = namaKanal[r.electrode];
        if (KANAL.includes(nama)) terimaEeg(nama, r.samples);
    }));

    // accGyroReadings: satu sampel {acc:{x,y,z} dalam g, gyro} per emisi.
    state.langganan.push(client.accGyroReadings.subscribe((r) => {
        if (r.acc) terimaAccel([r.acc]);
    }));

    // opticalReadings (64 Hz): preset p1045 mengaktifkan Optics4 (4 kanal),
    // sepasang gelombang NIR (730 nm) lalu sepasang IR (850 nm) — urutan
    // pasti inner/outer belum terverifikasi ke perangkat fisik, tapi posisi
    // indeks 2-3 = kanal IR tetap konsisten di kedua kemungkinan tabel.
    // Kanal IR paling cocok untuk deteksi denyut nadi; indeks 2 dipakai,
    // fallback ke indeks 0 bila array datang lebih pendek dari dugaan.
    // Denyut dihitung sendiri di sini — Athena tidak punya stream PPG.
    state.langganan.push(client.opticalReadings.subscribe((r) => {
        if (r.samples && r.samples.length) {
            terimaPpg([r.samples.length > 2 ? r.samples[2] : r.samples[0]]);
        }
    }));

    if (client.batteryData) {
        state.langganan.push(client.batteryData.subscribe((b) => {
            if (b && b.values && b.values.length) {
                let persen = b.values[0];
                if (persen > 100) persen /= 512; // skala mentah firmware
                terimaBaterai(Math.max(0, Math.min(100, persen)));
            }
        }));
    }

    state.langganan.push(client.connectionStatus.subscribe((tersambung) => {
        if (!tersambung && state.mode === 'muse') {
            setStatus('putus', 'Koneksi terputus');
            hentikanSemua(true);
        }
    }));

    // p1045: EEG 4 kanal + Optics4 — kombinasi paling hemat yang tetap
    // memberi EEG, gerak kepala, dan denyut.
    await client.start('p1045');
}

/* =====================================================================
 * Mode demo — sinyal sintetis dengan skenario berubah fase supaya semua
 * indikator terlihat hidup tanpa headband.
 * =================================================================== */
function mulaiDemo() {
    hentikanSemua(false);
    resetKanal();
    state.mode = 'demo';
    $('info-perangkat').textContent = 'Simulasi (tanpa perangkat)';
    setStatus('demo', 'Mode Demo — sinyal sintetis');
    terimaBaterai(87);
    aturTombol(true);

    let t = 0; // detik simulasi
    const mulaiDetik = performance.now() / 1000;

    // Fase demo 3 menit berulang: 0-60 normal, 60-120 fokus berat,
    // 120-180 lelah + postur menunduk.
    const fase = () => {
        const dt = (t % 180);
        if (dt < 60) return 'normal';
        if (dt < 120) return 'fokus';
        return 'lelah';
    };

    // EEG: paket 12 sampel per kanal tiap 46.875 ms
    let nEeg = 0;
    state.demoTimer.push(setInterval(() => {
        t = performance.now() / 1000 - mulaiDetik;
        const f = fase();
        for (const nama of KANAL) {
            const samples = [];
            for (let i = 0; i < 12; i++) {
                const waktu = (nEeg * 12 + i) / FS_EEG;
                let v = 0;
                // komposisi band tergantung fase
                const alpha = f === 'lelah' ? 26 : (f === 'fokus' ? 7 : 16);
                const theta = f === 'lelah' ? 22 : (f === 'fokus' ? 14 : 9);
                const beta = f === 'fokus' ? 18 : (f === 'lelah' ? 6 : 10);
                v += alpha * Math.sin(2 * Math.PI * 10 * waktu + (nama === 'TP9' ? 1 : 0));
                v += theta * Math.sin(2 * Math.PI * 6 * waktu + 2);
                v += beta * Math.sin(2 * Math.PI * 19 * waktu + 4);
                v += 4 * Math.sin(2 * Math.PI * 2.5 * waktu);
                v += (Math.random() - 0.5) * 8;
                // kedipan pada kanal frontal: tiap ~4 dtk (normal), jarang saat fokus
                const periodeKedip = f === 'fokus' ? 9 : (f === 'lelah' ? 2.5 : 4);
                if ((nama === 'AF7' || nama === 'AF8')
                    && Math.abs((waktu % periodeKedip) - periodeKedip / 2) < 0.06) {
                    v += 260;
                }
                samples.push(v);
            }
            terimaEeg(nama, samples);
        }
        nEeg++;
    }, 46.875));

    // Accelerometer: 3 sampel tiap ~57 ms; fase lelah = menunduk ±25°
    state.demoTimer.push(setInterval(() => {
        const f = fase();
        const target = f === 'lelah' ? 25 : (f === 'fokus' ? 8 : 3);
        const rad = ((target + Math.sin(t / 5) * 2) * Math.PI) / 180;
        const s = { x: 0.02 * Math.random(), y: Math.cos(rad), z: Math.sin(rad) };
        terimaAccel([s, s, s]);
    }, 57));

    // PPG: 6 sampel tiap 93.75 ms; HR naik saat fokus/lelah
    let nPpg = 0;
    state.demoTimer.push(setInterval(() => {
        const f = fase();
        const bpm = f === 'fokus' ? 84 : (f === 'lelah' ? 64 : 72);
        const hz = bpm / 60;
        const samples = [];
        for (let i = 0; i < 6; i++) {
            const waktu = (nPpg * 6 + i) / FS_PPG;
            samples.push(
                120000
                + 4000 * Math.sin(2 * Math.PI * hz * waktu)
                + 1200 * Math.sin(4 * Math.PI * hz * waktu + 1)
                + (Math.random() - 0.5) * 500
            );
        }
        terimaPpg(samples);
        nPpg++;
    }, 93.75));

    // Kalibrasi netral postur otomatis setelah 2 dtk pertama fase normal
    setTimeout(() => { if (state.mode === 'demo') state.postur.setNetral(); }, 2000);
}

/* =====================================================================
 * Putus koneksi / berhenti
 * =================================================================== */
function hentikanSemua(perbaruiUi) {
    for (const s of state.langganan) { try { s.unsubscribe(); } catch (e) { /* sudah lepas */ } }
    state.langganan = [];
    for (const timer of state.demoTimer) clearInterval(timer);
    state.demoTimer = [];
    if (state.client) {
        try { state.client.disconnect(); } catch (e) { /* sudah putus */ }
        state.client = null;
    }
    state.mode = null;
    if (perbaruiUi) {
        aturTombol(false);
        $('chip-baterai').style.display = 'none';
        $('info-perangkat').textContent = '—';
        if (state.perekam.aktif) selesaiRekam();
    }
}

/* =====================================================================
 * Kalibrasi baseline (60 detik)
 * =================================================================== */
function mulaiKalibrasi() {
    if (!state.mode) return;
    state.postur.setNetral();
    state.kalibrasi = { sisa: 60, sampel: { bebanKerja: [], kelelahan: [], fokus: [], relaksasi: [] } };
    $('tombol-kalibrasi').disabled = true;
    $('status-kalibrasi').textContent = 'Kalibrasi berjalan… duduk santai, pandang lurus, 60 detik.';
}

function langkahKalibrasi() {
    const kal = state.kalibrasi;
    if (!kal) return;
    for (const nama of MET.NAMA_INDEKS) {
        const v = state.indeks[nama];
        if (v !== null && isFinite(v)) kal.sampel[nama].push(v);
    }
    kal.sisa--;
    $('status-kalibrasi').textContent = `Kalibrasi… ${kal.sisa} detik lagi. Duduk santai, pandang lurus.`;
    if (kal.sisa > 0) return;

    // median tiap indeks sebagai baseline
    const indeks = {};
    let lengkap = true;
    for (const nama of MET.NAMA_INDEKS) {
        const arr = kal.sampel[nama].slice().sort((a, b) => a - b);
        if (arr.length < 10) { lengkap = false; continue; }
        indeks[nama] = arr[Math.floor(arr.length / 2)];
    }
    state.kalibrasi = null;
    $('tombol-kalibrasi').disabled = false;

    if (!lengkap) {
        $('status-kalibrasi').textContent = 'Kalibrasi gagal — sinyal belum stabil. Rapikan posisi headband lalu ulangi.';
        return;
    }
    state.baseline = { indeks, dibuat: new Date().toISOString() };
    localStorage.setItem(KUNCI_BASELINE, JSON.stringify(state.baseline));
    tampilkanBaseline();
    $('status-kalibrasi').textContent = 'Baseline personal tersimpan. Interpretasi kini relatif terhadap kondisi istirahatmu.';
}

function tampilkanBaseline() {
    if (!state.baseline) {
        $('info-baseline').textContent = 'Belum ada baseline — jalankan kalibrasi untuk interpretasi yang akurat.';
        return;
    }
    const b = state.baseline.indeks;
    $('info-baseline').textContent = 'Baseline: beban '
        + b.bebanKerja.toFixed(2) + ' · lelah ' + b.kelelahan.toFixed(2)
        + ' · fokus ' + b.fokus.toFixed(2) + ' · relaks ' + b.relaksasi.toFixed(2)
        + ' (' + new Date(state.baseline.dibuat).toLocaleString('id-ID') + ')';
}

/* =====================================================================
 * Loop komputasi 2 Hz: band power → indeks → kategori → UI
 * =================================================================== */
const LABEL_KATEGORI = { rendah: 'Rendah', normal: 'Normal', tinggi: 'Tinggi' };

function loopKomputasi() {
    if (!state.mode) return;

    const kini = performance.now();
    const perKanal = {};
    let frontalAgregat = null;

    for (const nama of KANAL) {
        const k = state.kanal[nama];

        // kualitas sinyal: putus (tanpa paket 2 dtk), lepas (datar),
        // baik / sedang / buruk berdasarkan std 1 detik terakhir
        if (kini - k.paketTerakhir > 2000) k.kualitas = 'putus';
        else {
            const std = DSP.std(k.ring.latest(FS_EEG));
            if (std < 1.5) k.kualitas = 'lepas';
            else if (std < 45) k.kualitas = 'baik';
            else if (std < 150) k.kualitas = 'sedang';
            else k.kualitas = 'buruk';
        }
        perbaruiKualitasUi(nama, k.kualitas);

        const layak = k.kualitas === 'baik' || k.kualitas === 'sedang';
        perKanal[nama] = layak ? DSP.bandPowers(k.ring.latest(FS_EEG * 4), FS_EEG, 256) : null;
    }

    // spektrum dari rata-rata kanal yang hidup
    const hidup = KANAL.map((n) => perKanal[n]).filter(Boolean);
    if (hidup.length) {
        const agg = { delta: 0, theta: 0, alpha: 0, beta: 0, gamma: 0, total: 0 };
        for (const bp of hidup) {
            for (const kunci of Object.keys(agg)) agg[kunci] += bp[kunci] / hidup.length;
        }
        frontalAgregat = agg;
    }
    state.bandTerakhir = frontalAgregat;

    state.indeks = MET.hitungIndeks(perKanal);

    for (const nama of MET.NAMA_INDEKS) {
        const nilai = state.indeks[nama];
        $('nilai-' + nama).textContent = nilai === null ? '—' : nilai.toFixed(2);

        let rasio = null;
        if (nilai !== null && state.baseline && state.baseline.indeks[nama]) {
            rasio = nilai / state.baseline.indeks[nama];
            state.kategori[nama] = state.histeresis[nama].update(rasio);
        } else {
            state.kategori[nama] = null;
        }
        perbaruiKategoriUi(nama, state.kategori[nama], MET.ATURAN_KATEGORI[nama]);
        if (state.grafik['gauge-' + nama]) state.grafik['gauge-' + nama].gambar(rasio);
    }

    // kedipan
    const laju = state.kedip.lajuPerMenit(60);
    $('nilai-kedip').textContent = laju === null ? '—' : laju.toFixed(0) + '/mnt';

    // postur
    const deviasi = state.postur.deviasiDerajat();
    const skor = MET.PosturKepala.skorRula(deviasi);
    $('nilai-postur').textContent = deviasi === null ? '—' : deviasi.toFixed(0) + '°';
    $('nilai-postur-skor').textContent = skor === null ? 'Kalibrasi netral dulu' : 'Skor leher RULA: ' + skor;
    aturChipPostur(MET.PosturKepala.kategori(deviasi));

    // jantung
    if (state.ppgAda) {
        $('kartu-jantung').style.display = '';
        const bpm = state.jantung.bpm();
        const rmssd = state.jantung.rmssd(60);
        $('nilai-bpm').textContent = bpm === null ? '—' : bpm.toFixed(0);
        $('nilai-rmssd').textContent = rmssd === null ? '—' : rmssd.toFixed(0) + ' ms';
    }

    if (state.kalibrasi) langkahKalibrasi();
}

function snapshotPerDetik() {
    if (!state.perekam.aktif) return;
    const deviasi = state.postur.deviasiDerajat();
    state.perekam.tambah({
        t: state.perekam.snapshot.length + 1,
        indeks: { ...state.indeks },
        kategori: { ...state.kategori },
        kedipPerMenit: state.kedip.lajuPerMenit(60),
        posturDeviasi: deviasi,
        posturKategori: MET.PosturKepala.kategori(deviasi),
        bpm: state.ppgAda ? state.jantung.bpm() : null,
        rmssd: state.ppgAda ? state.jantung.rmssd(60) : null,
    });
    const d = state.perekam.snapshot.length;
    $('rekam-timer').textContent = Math.floor(d / 60) + ':' + String(d % 60).padStart(2, '0');
}

/* =====================================================================
 * Rekam sesi + laporan
 * =================================================================== */
let ringkasanTerakhir = null;

function mulaiRekam() {
    if (!state.mode) return;
    if (!state.baseline) {
        if (!confirm('Belum ada baseline kalibrasi — kategori indeks tidak akan terisi. Tetap mulai merekam?')) return;
    }
    state.perekam.mulai();
    $('tombol-rekam').style.display = 'none';
    $('tombol-stop').style.display = '';
    $('panel-laporan').style.display = 'none';
    $('rekam-status').textContent = 'Merekam…';
}

function selesaiRekam() {
    ringkasanTerakhir = state.perekam.selesai();
    $('tombol-rekam').style.display = '';
    $('tombol-stop').style.display = 'none';
    $('rekam-status').textContent = 'Rekaman selesai.';
    if (!ringkasanTerakhir || ringkasanTerakhir.durasiDetik < 10) {
        $('rekam-status').textContent = 'Rekaman terlalu pendek (<10 dtk) — tidak dibuatkan laporan.';
        return;
    }
    tampilkanLaporan(ringkasanTerakhir);
}

function tampilkanLaporan(r) {
    $('panel-laporan').style.display = '';

    const fmt = (v, digit = 2) => (v === null || v === undefined || !isFinite(v) ? '—' : (+v).toFixed(digit));
    const menit = Math.floor(r.durasiDetik / 60);
    $('laporan-meta').textContent = `Durasi ${menit} mnt ${r.durasiDetik % 60} dtk · ${r.jumlahSnapshot} titik data`
        + (state.baseline ? '' : ' · TANPA baseline (kategori kosong)');

    const barisIndeks = MET.NAMA_INDEKS.map((nama) => {
        const x = r.indeks[nama];
        const label = { bebanKerja: 'Beban Kerja', kelelahan: 'Kelelahan', fokus: 'Fokus', relaksasi: 'Relaksasi' }[nama];
        const pk = x.persenKategori || {};
        const dist = ['rendah', 'normal', 'tinggi']
            .filter((kat) => pk[kat])
            .map((kat) => `${LABEL_KATEGORI[kat]} ${pk[kat]}%`)
            .join(' · ') || '—';
        return `<tr><td>${label}</td><td>${fmt(x.rata)}</td><td>${fmt(x.maks)}</td><td>${dist}</td></tr>`;
    }).join('');
    $('laporan-tabel').innerHTML = barisIndeks;

    $('laporan-lain').innerHTML = [
        `Kedipan: rata ${fmt(r.kedipPerMenit.rata, 1)}/mnt`,
        `Postur: deviasi rata ${fmt(r.postur.deviasiRata, 1)}° (maks ${fmt(r.postur.deviasiMaks, 1)}°)`
        + (r.postur.persenKategori.berat ? ` — ${r.postur.persenKategori.berat}% waktu >20°` : ''),
        r.jantung ? `Jantung: ${fmt(r.jantung.bpmRata, 0)} bpm rata (${fmt(r.jantung.bpmMin, 0)}–${fmt(r.jantung.bpmMaks, 0)}), RMSSD ${fmt(r.jantung.rmssdRata, 0)} ms` : null,
    ].filter(Boolean).map((teksBaris) => `<span class="lapor-chip">${teksBaris}</span>`).join('');

    // garis waktu
    const snap = state.perekam.snapshot;
    state.grafik.tlBeban.gambar(snap.map((x) => ({ t: x.t, v: x.indeks.bebanKerja })),
        state.baseline ? state.baseline.indeks.bebanKerja : null);
    state.grafik.tlLelah.gambar(snap.map((x) => ({ t: x.t, v: x.indeks.kelelahan })),
        state.baseline ? state.baseline.indeks.kelelahan : null);
    state.grafik.tlPostur.gambar(snap.map((x) => ({ t: x.t, v: x.posturDeviasi })), 10);

    // interpretasi
    const temuan = MET.interpretasi(r);
    $('laporan-interpretasi').innerHTML = temuan.map((x) =>
        `<li class="interpretasi-${x.tingkat}">${x.teks}</li>`).join('');

    $('simpan-status').textContent = '';
}

function unduhCsv() {
    if (!state.perekam.snapshot.length) return;
    const blob = new Blob([state.perekam.keCsv()], { type: 'text/csv;charset=utf-8' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'muse-lab-sesi-' + new Date().toISOString().slice(0, 19).replace(/[:T]/g, '-') + '.csv';
    a.click();
    URL.revokeObjectURL(a.href);
}

async function simpanKeServer() {
    if (!ringkasanTerakhir) return;
    const nama = $('input-subjek').value.trim();
    if (!nama) {
        $('simpan-status').textContent = 'Isi nama subjek dulu.';
        return;
    }
    $('simpan-status').textContent = 'Menyimpan…';
    try {
        const jawab = await fetch(window.MUSE_LAB_CONFIG.simpanUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.MUSE_LAB_CONFIG.csrf,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                nama_subjek: nama,
                aktivitas: $('input-aktivitas').value.trim() || null,
                perangkat: $('info-perangkat').textContent,
                mode_demo: state.mode === 'demo' || $('info-perangkat').textContent.startsWith('Simulasi'),
                mulai_pada: state.perekam.mulaiPada.toISOString(),
                durasi_detik: ringkasanTerakhir.durasiDetik,
                ringkasan: { ...ringkasanTerakhir, interpretasi: MET.interpretasi(ringkasanTerakhir).map((x) => x.teks) },
                catatan: null,
            }),
        });
        if (!jawab.ok) throw new Error('HTTP ' + jawab.status);
        const data = await jawab.json();
        $('simpan-status').textContent = 'Tersimpan di server (sesi #' + data.id + ') — bisa dilihat admin di panel.';
    } catch (e) {
        $('simpan-status').textContent = 'Gagal menyimpan: ' + (e.message || e);
    }
}

/* =====================================================================
 * UI kecil-kecil
 * =================================================================== */
function setStatus(kelas, teks) {
    const dot = $('status-dot');
    dot.className = 'dot ' + kelas;
    $('status-teks').textContent = teks;
}

function aturTombol(terhubung) {
    $('tombol-hubungkan').style.display = terhubung ? 'none' : '';
    $('tombol-demo').style.display = terhubung ? 'none' : '';
    $('tombol-putuskan').style.display = terhubung ? '' : 'none';
    $('tombol-kalibrasi').disabled = !terhubung;
    $('tombol-rekam').disabled = !terhubung;
    $('tombol-netral').disabled = !terhubung;
}

function tampilkanGalat(pesan) {
    const el = $('galat');
    el.textContent = pesan;
    el.style.display = '';
    clearTimeout(tampilkanGalat._t);
    tampilkanGalat._t = setTimeout(() => { el.style.display = 'none'; }, 9000);
}

function perbaruiKualitasUi(nama, kualitas) {
    const el = $('kualitas-' + nama);
    if (!el) return;
    el.className = 'kualitas ' + kualitas;
    el.title = { putus: 'Tidak ada data', lepas: 'Elektroda tidak menempel', baik: 'Sinyal baik', sedang: 'Sinyal cukup', buruk: 'Banyak artefak' }[kualitas];
}

function perbaruiKategoriUi(nama, kategori, aturan) {
    const chip = $('kategori-' + nama);
    if (!chip) return;
    if (!kategori) {
        chip.textContent = state.baseline ? '…' : 'perlu kalibrasi';
        chip.className = 'chip-kategori kosong';
        return;
    }
    chip.textContent = LABEL_KATEGORI[kategori];
    let rupa = 'aman';
    if (kategori === 'tinggi') rupa = aturan.naikBuruk ? 'bahaya' : 'aman';
    else if (kategori === 'rendah') rupa = aturan.naikBuruk ? 'aman' : 'waspada';
    chip.className = 'chip-kategori ' + rupa;
}

function aturChipPostur(kategori) {
    const chip = $('kategori-postur');
    if (!kategori) { chip.textContent = '—'; chip.className = 'chip-kategori kosong'; return; }
    chip.textContent = { netral: 'Netral', ringan: 'Menekuk 10–20°', berat: 'Menekuk >20°' }[kategori];
    chip.className = 'chip-kategori ' + { netral: 'aman', ringan: 'waspada', berat: 'bahaya' }[kategori];
}

/* =====================================================================
 * Inisialisasi halaman
 * =================================================================== */
function init() {
    // grafik gelombang per kanal
    const warna = { TP9: '#34d399', AF7: '#4f7df3', AF8: '#38bdf8', TP10: '#a78bfa' };
    for (const nama of KANAL) {
        state.grafik['gelombang-' + nama] = new CH.Gelombang($('gelombang-' + nama), { detik: 4, fs: FS_EEG, warna: warna[nama] });
    }
    state.grafik.spektrum = new CH.Spektrum($('kanvas-spektrum'));
    for (const nama of MET.NAMA_INDEKS) {
        const aturan = MET.ATURAN_KATEGORI[nama];
        state.grafik['gauge-' + nama] = new CH.Gauge($('gauge-' + nama), {
            naikBuruk: aturan.naikBuruk, batasTurun: aturan.turun, batasNaik: aturan.naik,
        });
    }
    state.grafik.tlBeban = new CH.GarisWaktu($('tl-beban'), { warna: '#f87171' });
    state.grafik.tlLelah = new CH.GarisWaktu($('tl-lelah'), { warna: '#fbbf24' });
    state.grafik.tlPostur = new CH.GarisWaktu($('tl-postur'), { warna: '#38bdf8' });

    // tombol
    $('tombol-hubungkan').addEventListener('click', hubungkanMuse);
    $('tombol-demo').addEventListener('click', mulaiDemo);
    $('tombol-putuskan').addEventListener('click', () => { hentikanSemua(true); setStatus('siap', 'Belum terhubung'); });
    $('tombol-kalibrasi').addEventListener('click', mulaiKalibrasi);
    $('tombol-netral').addEventListener('click', () => {
        if (state.postur.setNetral()) $('status-kalibrasi').textContent = 'Posisi kepala saat ini di-set sebagai netral.';
    });
    $('tombol-rekam').addEventListener('click', mulaiRekam);
    $('tombol-stop').addEventListener('click', selesaiRekam);
    $('tombol-csv').addEventListener('click', unduhCsv);
    $('tombol-simpan').addEventListener('click', simpanKeServer);

    if (!navigator.bluetooth) {
        $('peringatan-browser').style.display = '';
    }

    tampilkanBaseline();
    aturTombol(false);

    // loop gambar (rAF) — hanya gelombang & spektrum
    const gambar = () => {
        if (state.mode) {
            for (const nama of KANAL) state.grafik['gelombang-' + nama].gambar(state.kanal[nama].ring);
            state.grafik.spektrum.gambar(state.bandTerakhir);
        }
        requestAnimationFrame(gambar);
    };
    requestAnimationFrame(gambar);

    setInterval(loopKomputasi, 500);
    setInterval(snapshotPerDetik, 1000);
}

document.addEventListener('DOMContentLoaded', init);
