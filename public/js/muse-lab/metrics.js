/*
 * Muse Lab — indeks neuro-ergonomi dari band power EEG, accelerometer,
 * dan PPG. UMD: browser global `MuseMetrics`, Node lewat module.exports
 * (untuk unit test).
 *
 * Rumus mengikuti literatur neuro-ergonomi yang lazim untuk EEG konsumen:
 *  - Engagement/fokus  : beta / (alpha + theta)          (Pope dkk., 1995)
 *  - Beban kerja mental: theta frontal / alpha posterior (Gevins & Smith, 2003)
 *  - Kelelahan/kantuk  : (theta + alpha) / beta          (Jap dkk., 2009)
 *  - Relaksasi         : alpha relatif (alpha / total)
 * Nilai absolut EEG sangat bervariasi antar individu, jadi SEMUA kategori
 * dihitung relatif terhadap baseline personal hasil kalibrasi.
 */
(function (root, factory) {
    if (typeof module === 'object' && module.exports) {
        module.exports = factory();
    } else {
        root.MuseMetrics = factory();
    }
})(typeof self !== 'undefined' ? self : this, function () {
    'use strict';

    const FRONTAL = ['AF7', 'AF8'];
    const POSTERIOR = ['TP9', 'TP10'];

    function rataBand(perChannel, channels, band) {
        let sum = 0;
        let n = 0;
        for (const ch of channels) {
            const bp = perChannel[ch];
            if (bp && isFinite(bp[band]) && bp[band] > 0) {
                sum += bp[band];
                n++;
            }
        }
        return n > 0 ? sum / n : null;
    }

    /**
     * Empat indeks utama dari band power per kanal.
     * perChannel: { TP9: {delta..gamma,total}|null, AF7:..., AF8:..., TP10:... }
     * Kanal yang jelek/putus boleh null — indeks dihitung dari yang ada;
     * null bila data tidak cukup.
     */
    function hitungIndeks(perChannel) {
        const semua = [...FRONTAL, ...POSTERIOR];

        const thetaF = rataBand(perChannel, FRONTAL, 'theta');
        const alphaF = rataBand(perChannel, FRONTAL, 'alpha');
        // Indeks Pope memakai beta 13–22 Hz (betaRendah) untuk menghindari
        // EMG; jatuh ke beta penuh bila field itu tidak tersedia.
        const betaF = rataBand(perChannel, FRONTAL, 'betaRendah')
            ?? rataBand(perChannel, FRONTAL, 'beta');
        const alphaP = rataBand(perChannel, POSTERIOR, 'alpha');

        const theta = rataBand(perChannel, semua, 'theta');
        const alpha = rataBand(perChannel, semua, 'alpha');
        const beta = rataBand(perChannel, semua, 'beta');
        const total = rataBand(perChannel, semua, 'total');

        return {
            // Gevins: theta frontal naik & alpha posterior turun saat beban naik
            bebanKerja: thetaF !== null && alphaP !== null && alphaP > 0
                ? thetaF / alphaP : null,

            // Jap: rasio gelombang lambat/cepat naik saat mengantuk
            kelelahan: theta !== null && alpha !== null && beta !== null && beta > 0
                ? (theta + alpha) / beta : null,

            // Pope: engagement naik saat fokus pada tugas
            fokus: betaF !== null && alphaF !== null && thetaF !== null
                && (alphaF + thetaF) > 0
                ? betaF / (alphaF + thetaF) : null,

            // Alpha relatif: naik saat rileks/mata terpejam
            relaksasi: alpha !== null && total !== null && total > 0
                ? alpha / total : null,
        };
    }

    /* =====================================================================
     * Kategori relatif baseline, dengan histeresis supaya label tidak
     * berkedip-kedip di sekitar ambang.
     * =================================================================== */

    // Ambang rasio nilai/baseline per indeks. "naikBuruk" menandai arah:
    // true = makin tinggi makin perlu perhatian (beban, kelelahan).
    const ATURAN_KATEGORI = {
        bebanKerja: { naik: 1.35, turun: 0.75, naikBuruk: true },
        kelelahan: { naik: 1.4, turun: 0.75, naikBuruk: true },
        fokus: { naik: 1.3, turun: 0.7, naikBuruk: false },
        relaksasi: { naik: 1.3, turun: 0.7, naikBuruk: false },
    };

    class KategoriHisteresis {
        constructor(indeks) {
            this.aturan = ATURAN_KATEGORI[indeks];
            this.kategori = 'normal';
        }

        /** rasio = nilai sekarang / baseline. Mengembalikan 'rendah'|'normal'|'tinggi'. */
        update(rasio) {
            if (!isFinite(rasio) || rasio <= 0) return this.kategori;
            const { naik, turun } = this.aturan;
            // Histeresis: keluar dari kategori butuh melewati ambang lawannya
            // sebesar 10% ke arah dalam.
            if (this.kategori !== 'tinggi' && rasio > naik) this.kategori = 'tinggi';
            else if (this.kategori !== 'rendah' && rasio < turun) this.kategori = 'rendah';
            else if (this.kategori === 'tinggi' && rasio < naik * 0.9) this.kategori = 'normal';
            else if (this.kategori === 'rendah' && rasio > turun * 1.1) this.kategori = 'normal';
            return this.kategori;
        }
    }

    /* =====================================================================
     * Deteksi kedipan dari EEG frontal (AF7/AF8).
     * Kedipan tampak sebagai defleksi besar (ratusan µV) ~200-400 ms.
     * Laju normal ±10-20/menit; <8 menandakan menatap layar terlalu intens
     * (kelelahan visual), >25 menandakan kelelahan umum.
     * =================================================================== */
    class DeteksiKedip {
        constructor(fs) {
            this.fs = fs;
            this.refractorySampel = Math.round(0.3 * fs);
            this.sejakKedip = this.refractorySampel;
            this.jendelaStd = [];
            this.waktuKedip = []; // detik (waktu sampel kumulatif)
            this.totalSampel = 0;
        }

        /** Umpankan sampel frontal TERFILTER satu per satu. */
        proses(nilai) {
            this.totalSampel++;
            this.sejakKedip++;

            // std berjalan dari jendela 2 detik untuk ambang adaptif
            this.jendelaStd.push(nilai);
            if (this.jendelaStd.length > this.fs * 2) this.jendelaStd.shift();

            if (this.jendelaStd.length < this.fs) return false;

            const n = this.jendelaStd.length;
            let mean = 0;
            for (const v of this.jendelaStd) mean += v;
            mean /= n;
            let varAcc = 0;
            for (const v of this.jendelaStd) varAcc += (v - mean) * (v - mean);
            const std = Math.sqrt(varAcc / n);

            const ambang = Math.max(80, 3 * std); // µV
            if (Math.abs(nilai - mean) > ambang && this.sejakKedip >= this.refractorySampel) {
                this.sejakKedip = 0;
                this.waktuKedip.push(this.totalSampel / this.fs);
                return true;
            }
            return false;
        }

        /** Kedipan per menit dalam jendela `detik` terakhir. */
        lajuPerMenit(detik = 60) {
            const sekarang = this.totalSampel / this.fs;
            if (sekarang < 5) return null;
            const jendela = Math.min(detik, sekarang);
            const batas = sekarang - jendela;
            const jumlah = this.waktuKedip.filter((t) => t >= batas).length;
            return (jumlah * 60) / jendela;
        }
    }

    /* =====================================================================
     * Postur kepala/leher dari accelerometer headband.
     *
     * Pendekatan bebas-orientasi: saat kalibrasi, vektor gravitasi posisi
     * netral disimpan; sudut deviasi = sudut antara vektor gravitasi kini
     * dan vektor netral. Tanda fleksi (menunduk) vs ekstensi (mendongak)
     * diambil dari proyeksi pada sumbu depan yang diestimasi dari gerakan
     * pertama kali pengguna menunduk — namun untuk keandalan lintas
     * perangkat, skor RULA memakai besaran deviasi:
     *   <10° = skor 1 (netral), 10-20° = skor 2, >20° = skor 3+.
     * (RULA memberi skor 4 untuk ekstensi; tanpa arah yang pasti kita
     *  konservatif memakai skor berbasis besaran.)
     * =================================================================== */
    class PosturKepala {
        constructor() {
            this.g = null;        // gravitasi ter-lowpass {x,y,z}
            this.netral = null;   // vektor netral ternormalisasi
            this.alfa = 0.1;      // koefisien low-pass (≈0.5 s pada 52 Hz)
            this.riwayat = [];    // {t, deviasi, skor} per update kategori
        }

        update(sampel) {
            // Gerbang validitas: saat kepala bergerak dinamis, akselerometer
            // mengukur gravitasi + percepatan gerak sehingga arahnya bukan
            // lagi arah gravitasi. Sampel dengan |a| jauh dari 1 g dibuang.
            const besar = Math.hypot(sampel.x, sampel.y, sampel.z);
            if (besar < 0.85 || besar > 1.15) return;

            if (!this.g) {
                this.g = { x: sampel.x, y: sampel.y, z: sampel.z };
            } else {
                this.g.x += this.alfa * (sampel.x - this.g.x);
                this.g.y += this.alfa * (sampel.y - this.g.y);
                this.g.z += this.alfa * (sampel.z - this.g.z);
            }
        }

        setNetral() {
            if (!this.g) return false;
            const m = Math.hypot(this.g.x, this.g.y, this.g.z);
            if (m === 0) return false;
            this.netral = { x: this.g.x / m, y: this.g.y / m, z: this.g.z / m };
            return true;
        }

        /** Sudut deviasi dari netral dalam derajat, atau null. */
        deviasiDerajat() {
            if (!this.g || !this.netral) return null;
            const m = Math.hypot(this.g.x, this.g.y, this.g.z);
            if (m === 0) return null;
            const dot = (this.g.x * this.netral.x + this.g.y * this.netral.y + this.g.z * this.netral.z) / m;
            const d = Math.min(1, Math.max(-1, dot));
            return (Math.acos(d) * 180) / Math.PI;
        }

        /** Skor leher ala RULA dari besaran deviasi. */
        static skorRula(deviasi) {
            if (deviasi === null) return null;
            if (deviasi < 10) return 1;
            if (deviasi < 20) return 2;
            return 3;
        }

        static kategori(deviasi) {
            if (deviasi === null) return null;
            if (deviasi < 10) return 'netral';
            if (deviasi < 20) return 'ringan';
            return 'berat';
        }
    }

    /* =====================================================================
     * Detak jantung + HRV (RMSSD) dari PPG.
     * PPG difilter band-pass 0.7–3.5 Hz (42–210 bpm) di luar kelas ini;
     * kelas ini menerima sampel terfilter dan mendeteksi puncak.
     * =================================================================== */
    class EstimasiJantung {
        constructor(fs) {
            this.fs = fs;
            this.jarakMinSampel = Math.round(0.3 * fs); // maks 200 bpm
            this.sejakPuncak = this.jarakMinSampel;
            this.prev2 = 0;
            this.prev1 = 0;
            this.jendela = [];
            this.ibi = [];       // interval antar-puncak (ms), sudah disaring
            this.totalSampel = 0;
            this.puncakTerakhir = null; // indeks sampel puncak terakhir
        }

        proses(nilai) {
            this.totalSampel++;
            this.sejakPuncak++;

            this.jendela.push(nilai);
            if (this.jendela.length > this.fs * 3) this.jendela.shift();

            let hasil = false;
            if (this.jendela.length >= this.fs) {
                let mean = 0;
                for (const v of this.jendela) mean += v;
                mean /= this.jendela.length;
                let varAcc = 0;
                for (const v of this.jendela) varAcc += (v - mean) * (v - mean);
                const std = Math.sqrt(varAcc / this.jendela.length);
                const ambang = mean + 0.5 * std;

                // puncak lokal: prev1 lebih tinggi dari tetangganya & di atas ambang
                if (this.prev1 > ambang && this.prev1 >= this.prev2 && this.prev1 > nilai
                    && this.sejakPuncak >= this.jarakMinSampel) {
                    // Interpolasi parabola pada 3 titik di sekitar puncak:
                    // resolusi mentah 64 Hz (15,6 ms) terlalu kasar untuk
                    // RMSSD, sub-sampel wajib diestimasi.
                    const penyebut = this.prev2 - 2 * this.prev1 + nilai;
                    let geser = 0;
                    if (penyebut !== 0) {
                        geser = 0.5 * (this.prev2 - nilai) / penyebut;
                        if (!isFinite(geser) || Math.abs(geser) > 0.5) geser = 0;
                    }
                    const indeksPuncak = this.totalSampel - 1 + geser;
                    if (this.puncakTerakhir !== null) {
                        const ibiMs = ((indeksPuncak - this.puncakTerakhir) / this.fs) * 1000;
                        // interval masuk akal: 300–2000 ms (30–200 bpm)
                        if (ibiMs >= 300 && ibiMs <= 2000) {
                            this.ibi.push({ t: indeksPuncak / this.fs, ms: ibiMs });
                            if (this.ibi.length > 300) this.ibi.shift();
                            hasil = true;
                        }
                    }
                    this.puncakTerakhir = indeksPuncak;
                    this.sejakPuncak = 0;
                }
            }

            this.prev2 = this.prev1;
            this.prev1 = nilai;
            return hasil;
        }

        /** Detak per menit dari IBI 10 detik terakhir, atau null. */
        bpm() {
            const sekarang = this.totalSampel / this.fs;
            const baru = this.ibi.filter((x) => x.t >= sekarang - 10);
            if (baru.length < 3) return null;
            const rata = baru.reduce((a, b) => a + b.ms, 0) / baru.length;
            return 60000 / rata;
        }

        /** RMSSD (ms) dari IBI `detik` terakhir — HRV jangka pendek. */
        rmssd(detik = 60) {
            const sekarang = this.totalSampel / this.fs;
            const baru = this.ibi.filter((x) => x.t >= sekarang - detik);
            if (baru.length < 5) return null;
            let acc = 0;
            for (let i = 1; i < baru.length; i++) {
                const d = baru[i].ms - baru[i - 1].ms;
                acc += d * d;
            }
            return Math.sqrt(acc / (baru.length - 1));
        }
    }

    /* =====================================================================
     * Perekam sesi: snapshot metrik per detik → ringkasan + CSV.
     * =================================================================== */
    const NAMA_INDEKS = ['bebanKerja', 'kelelahan', 'fokus', 'relaksasi'];

    class PerekamSesi {
        constructor() {
            this.aktif = false;
            this.snapshot = [];
            this.mulaiPada = null;
        }

        mulai() {
            this.aktif = true;
            this.snapshot = [];
            this.mulaiPada = new Date();
        }

        /**
         * snap: { t, indeks:{...}, kategori:{...}, kedipPerMenit,
         *         posturDeviasi, posturKategori, bpm, rmssd, kualitas }
         */
        tambah(snap) {
            if (this.aktif) this.snapshot.push(snap);
        }

        selesai() {
            this.aktif = false;
            return this.ringkasan();
        }

        get durasiDetik() {
            return this.snapshot.length ? Math.round(this.snapshot[this.snapshot.length - 1].t) : 0;
        }

        ringkasan() {
            const s = this.snapshot;
            if (!s.length) return null;

            const ambil = (kunci) => s.map((x) => x[kunci]).filter((v) => v !== null && isFinite(v));
            const rata = (arr) => (arr.length ? arr.reduce((a, b) => a + b, 0) / arr.length : null);
            const maks = (arr) => (arr.length ? Math.max(...arr) : null);

            const indeks = {};
            for (const nama of NAMA_INDEKS) {
                const nilai = s.map((x) => x.indeks && x.indeks[nama]).filter((v) => v !== null && v !== undefined && isFinite(v));
                const kategori = s.map((x) => x.kategori && x.kategori[nama]).filter(Boolean);
                const distribusi = {};
                for (const k of kategori) distribusi[k] = (distribusi[k] || 0) + 1;
                for (const k of Object.keys(distribusi)) {
                    distribusi[k] = Math.round((100 * distribusi[k]) / kategori.length);
                }
                indeks[nama] = {
                    rata: rata(nilai),
                    maks: maks(nilai),
                    persenKategori: distribusi,
                };
            }

            const deviasi = ambil('posturDeviasi');
            const posturKategori = s.map((x) => x.posturKategori).filter(Boolean);
            const distPostur = {};
            for (const k of posturKategori) distPostur[k] = (distPostur[k] || 0) + 1;
            for (const k of Object.keys(distPostur)) {
                distPostur[k] = Math.round((100 * distPostur[k]) / posturKategori.length);
            }

            const bpm = ambil('bpm');
            const rmssd = ambil('rmssd');
            const kedip = ambil('kedipPerMenit');

            return {
                jumlahSnapshot: s.length,
                durasiDetik: this.durasiDetik,
                indeks,
                kedipPerMenit: { rata: rata(kedip), maks: maks(kedip) },
                postur: {
                    deviasiRata: rata(deviasi),
                    deviasiMaks: maks(deviasi),
                    persenKategori: distPostur,
                },
                jantung: bpm.length
                    ? { bpmRata: rata(bpm), bpmMin: Math.min(...bpm), bpmMaks: maks(bpm), rmssdRata: rata(rmssd) }
                    : null,
            };
        }

        keCsv() {
            const kolom = ['t_detik', ...NAMA_INDEKS,
                ...NAMA_INDEKS.map((n) => 'kategori_' + n),
                'kedip_per_menit', 'postur_deviasi_derajat', 'postur_kategori', 'bpm', 'rmssd_ms'];
            const baris = [kolom.join(',')];
            for (const x of this.snapshot) {
                const nilai = [
                    x.t.toFixed(1),
                    ...NAMA_INDEKS.map((n) => fmt(x.indeks && x.indeks[n])),
                    ...NAMA_INDEKS.map((n) => (x.kategori && x.kategori[n]) || ''),
                    fmt(x.kedipPerMenit),
                    fmt(x.posturDeviasi),
                    x.posturKategori || '',
                    fmt(x.bpm),
                    fmt(x.rmssd),
                ];
                baris.push(nilai.join(','));
            }
            return baris.join('\n');

            function fmt(v) {
                return v === null || v === undefined || !isFinite(v) ? '' : (+v).toFixed(3);
            }
        }
    }

    /* =====================================================================
     * Interpretasi otomatis berbahasa Indonesia (berbasis aturan).
     * Mengembalikan daftar {tingkat: 'baik'|'info'|'perhatian', teks}.
     * =================================================================== */
    function interpretasi(ringkasan) {
        if (!ringkasan) return [];
        const hasil = [];
        const idx = ringkasan.indeks || {};
        const pct = (nama, kat) => (idx[nama] && idx[nama].persenKategori && idx[nama].persenKategori[kat]) || 0;

        // Beban kerja mental
        if (pct('bebanKerja', 'tinggi') >= 50) {
            hasil.push({
                tingkat: 'perhatian',
                teks: `Beban kerja mental TINGGI selama ${pct('bebanKerja', 'tinggi')}% sesi. `
                    + 'Pertimbangkan memecah tugas menjadi tahap lebih kecil, menyederhanakan tampilan informasi, atau menambah jeda mikro (mis. 30 detik tiap 20 menit).',
            });
        } else if (pct('bebanKerja', 'tinggi') >= 25) {
            hasil.push({
                tingkat: 'info',
                teks: `Beban kerja mental sempat tinggi (${pct('bebanKerja', 'tinggi')}% sesi) — masih wajar untuk tugas menuntut, tapi pantau bila berulang.`,
            });
        } else {
            hasil.push({ tingkat: 'baik', teks: 'Beban kerja mental terkendali sepanjang sesi.' });
        }

        // Kelelahan / kantuk
        if (pct('kelelahan', 'tinggi') >= 40) {
            hasil.push({
                tingkat: 'perhatian',
                teks: `Tanda kantuk/kelelahan muncul pada ${pct('kelelahan', 'tinggi')}% sesi. `
                    + 'Untuk tugas kritis (mis. mengemudi, operasi mesin) ini sinyal untuk berhenti dan beristirahat; untuk kerja kantor, terapkan istirahat aktif dan cek kualitas tidur.',
            });
        } else if (pct('kelelahan', 'tinggi') >= 15) {
            hasil.push({ tingkat: 'info', teks: 'Kelelahan ringan terdeteksi di sebagian sesi — jadwalkan istirahat sebelum performa menurun.' });
        } else {
            hasil.push({ tingkat: 'baik', teks: 'Tingkat kewaspadaan terjaga baik.' });
        }

        // Fokus
        if (pct('fokus', 'rendah') >= 50) {
            hasil.push({
                tingkat: 'info',
                teks: `Engagement rendah pada ${pct('fokus', 'rendah')}% sesi — bisa menandakan tugas monoton atau di bawah kapasitas. `
                    + 'Rotasi tugas atau variasi stimulus dapat membantu.',
            });
        }

        // Kedipan mata
        const kedip = ringkasan.kedipPerMenit && ringkasan.kedipPerMenit.rata;
        if (kedip !== null && kedip !== undefined) {
            if (kedip < 8) {
                hasil.push({
                    tingkat: 'perhatian',
                    teks: `Laju kedip rendah (${kedip.toFixed(1)}/menit) — khas menatap layar terlalu intens dan berisiko mata kering. `
                        + 'Terapkan aturan 20-20-20: tiap 20 menit, pandang objek berjarak ±6 m selama 20 detik.',
                });
            } else if (kedip > 25) {
                hasil.push({
                    tingkat: 'info',
                    teks: `Laju kedip tinggi (${kedip.toFixed(1)}/menit) dapat menyertai kelelahan — cocokkan dengan indeks kelelahan di atas.`,
                });
            }
        }

        // Postur leher
        const postur = ringkasan.postur || {};
        const berat = (postur.persenKategori && postur.persenKategori.berat) || 0;
        const ringan = (postur.persenKategori && postur.persenKategori.ringan) || 0;
        if (berat >= 30) {
            hasil.push({
                tingkat: 'perhatian',
                teks: `Kepala menekuk >20° (skor RULA leher 3) selama ${berat}% sesi — risiko keluhan leher/bahu. `
                    + 'Naikkan layar hingga tepi atasnya sejajar mata, dekatkan dokumen kerja, dan hindari menunduk ke gawai.',
            });
        } else if (berat + ringan >= 50) {
            hasil.push({
                tingkat: 'info',
                teks: 'Postur leher sering keluar dari zona netral (>10°). Atur ulang ketinggian kursi/meja/layar agar pandangan lurus ke depan.',
            });
        } else if (postur.deviasiRata !== null && postur.deviasiRata !== undefined) {
            hasil.push({ tingkat: 'baik', teks: 'Postur kepala/leher dominan netral — pertahankan penataan stasiun kerja ini.' });
        }

        // Jantung
        const jantung = ringkasan.jantung;
        if (jantung && jantung.rmssdRata !== null && jantung.rmssdRata < 20) {
            hasil.push({
                tingkat: 'info',
                teks: `Variabilitas detak jantung rendah (RMSSD ${jantung.rmssdRata.toFixed(0)} ms) — dapat menandakan stres/ketegangan. `
                    + 'Latihan napas 4-6 (tarik 4 detik, hembus 6 detik) selama 2 menit dapat membantu.',
            });
        }

        return hasil;
    }

    return {
        FRONTAL,
        POSTERIOR,
        NAMA_INDEKS,
        ATURAN_KATEGORI,
        hitungIndeks,
        KategoriHisteresis,
        DeteksiKedip,
        PosturKepala,
        EstimasiJantung,
        PerekamSesi,
        interpretasi,
    };
});
