/*
 * Unit test modul metrik Muse Lab. Jalankan: node tests/js/metrics.test.cjs
 */
const assert = require('node:assert');
const M = require('../../public/js/muse-lab/metrics.js');

let lulus = 0;
function uji(nama, fn) {
    fn();
    lulus++;
    console.log('OK  ' + nama);
}

function bp(delta, theta, alpha, beta, gamma) {
    return { delta, theta, alpha, beta, gamma, total: delta + theta + alpha + beta + gamma };
}

/* ===== hitungIndeks ===== */
uji('hitungIndeks menghasilkan rasio yang benar', () => {
    const kanal = {
        AF7: bp(1, 4, 2, 6, 1),
        AF8: bp(1, 4, 2, 6, 1),
        TP9: bp(1, 2, 8, 4, 1),
        TP10: bp(1, 2, 8, 4, 1),
    };
    const idx = M.hitungIndeks(kanal);
    assert.ok(Math.abs(idx.bebanKerja - 4 / 8) < 1e-9, 'bebanKerja = thetaF/alphaP');
    // theta rata = 3, alpha rata = 5, beta rata = 5 → (3+5)/5
    assert.ok(Math.abs(idx.kelelahan - 8 / 5) < 1e-9, 'kelelahan = (theta+alpha)/beta');
    assert.ok(Math.abs(idx.fokus - 6 / (2 + 4)) < 1e-9, 'fokus = betaF/(alphaF+thetaF)');
    assert.ok(idx.relaksasi > 0 && idx.relaksasi < 1, 'relaksasi = alpha relatif');
});

uji('hitungIndeks toleran kanal mati (null)', () => {
    const kanal = { AF7: bp(1, 4, 2, 6, 1), AF8: null, TP9: null, TP10: bp(1, 2, 8, 4, 1) };
    const idx = M.hitungIndeks(kanal);
    assert.ok(idx.bebanKerja !== null && isFinite(idx.bebanKerja));
});

uji('hitungIndeks mengembalikan null bila semua kanal mati', () => {
    const idx = M.hitungIndeks({ AF7: null, AF8: null, TP9: null, TP10: null });
    assert.strictEqual(idx.bebanKerja, null);
    assert.strictEqual(idx.kelelahan, null);
});

/* ===== KategoriHisteresis ===== */
uji('kategori naik ke tinggi lalu butuh turun jauh untuk normal (histeresis)', () => {
    const k = new M.KategoriHisteresis('bebanKerja'); // naik 1.35, turun 0.75
    assert.strictEqual(k.update(1.0), 'normal');
    assert.strictEqual(k.update(1.4), 'tinggi');
    assert.strictEqual(k.update(1.3), 'tinggi');   // masih di atas 1.35*0.9=1.215
    assert.strictEqual(k.update(1.2), 'normal');   // turun melewati 1.215
    assert.strictEqual(k.update(0.7), 'rendah');
    assert.strictEqual(k.update(0.8), 'rendah');   // 0.75*1.1=0.825 belum terlampaui
    assert.strictEqual(k.update(0.9), 'normal');
});

/* ===== DeteksiKedip ===== */
uji('deteksi kedip menangkap lonjakan dan menghitung laju', () => {
    const fs = 256;
    const d = new M.DeteksiKedip(fs);
    // 60 detik: noise kecil + lonjakan 300 µV tiap 4 detik (15 kedip)
    let kedipTerdeteksi = 0;
    for (let i = 0; i < fs * 60; i++) {
        let v = 5 * Math.sin(i / 7) + (Math.random() - 0.5) * 4;
        if (i % (fs * 4) === fs * 2) v += 300;
        if (d.proses(v)) kedipTerdeteksi++;
    }
    assert.ok(kedipTerdeteksi >= 12 && kedipTerdeteksi <= 18, `terdeteksi ${kedipTerdeteksi}, harapan ±15`);
    const laju = d.lajuPerMenit(60);
    assert.ok(laju >= 12 && laju <= 18, `laju ${laju}/menit, harapan ±15`);
});

/* ===== PosturKepala ===== */
uji('postur: deviasi 15° terukur benar dan skor RULA sesuai', () => {
    const p = new M.PosturKepala();
    // posisi netral: gravitasi di sumbu y
    for (let i = 0; i < 60; i++) p.update({ x: 0, y: 1, z: 0 });
    assert.ok(p.setNetral());

    // miring 15°: y=cos15, z=sin15 — paksa konvergen low-pass
    const rad = (15 * Math.PI) / 180;
    for (let i = 0; i < 300; i++) p.update({ x: 0, y: Math.cos(rad), z: Math.sin(rad) });
    const dev = p.deviasiDerajat();
    assert.ok(Math.abs(dev - 15) < 1.5, `deviasi ${dev.toFixed(2)}°, harapan 15°`);
    assert.strictEqual(M.PosturKepala.skorRula(dev), 2);
    assert.strictEqual(M.PosturKepala.kategori(dev), 'ringan');
    assert.strictEqual(M.PosturKepala.skorRula(25), 3);
    assert.strictEqual(M.PosturKepala.kategori(5), 'netral');
});

/* ===== EstimasiJantung ===== */
uji('estimasi jantung ±72 bpm dari PPG sintetis', () => {
    const fs = 64;
    const j = new M.EstimasiJantung(fs);
    const f = 1.2; // Hz = 72 bpm
    for (let i = 0; i < fs * 30; i++) {
        // gelombang PPG-ish: sinus + harmonik supaya puncaknya tegas
        const t = i / fs;
        const v = Math.sin(2 * Math.PI * f * t) + 0.3 * Math.sin(4 * Math.PI * f * t + 1);
        j.proses(v);
    }
    const bpm = j.bpm();
    assert.ok(bpm !== null && Math.abs(bpm - 72) < 6, `bpm ${bpm}, harapan 72`);
    const rmssd = j.rmssd(30);
    assert.ok(rmssd !== null && rmssd < 30, `sinyal teratur → RMSSD kecil, dapat ${rmssd}`);
});

/* ===== PerekamSesi ===== */
uji('perekam sesi merangkum kategori dan CSV', () => {
    const r = new M.PerekamSesi();
    r.mulai();
    for (let t = 1; t <= 100; t++) {
        r.tambah({
            t,
            indeks: { bebanKerja: t <= 60 ? 2.0 : 1.0, kelelahan: 1.0, fokus: 1.0, relaksasi: 0.3 },
            kategori: {
                bebanKerja: t <= 60 ? 'tinggi' : 'normal',
                kelelahan: 'normal', fokus: 'normal', relaksasi: 'normal',
            },
            kedipPerMenit: 15,
            posturDeviasi: t <= 30 ? 25 : 5,
            posturKategori: t <= 30 ? 'berat' : 'netral',
            bpm: 75, rmssd: 40,
        });
    }
    const ringkasan = r.selesai();
    assert.strictEqual(ringkasan.jumlahSnapshot, 100);
    assert.strictEqual(ringkasan.indeks.bebanKerja.persenKategori.tinggi, 60);
    assert.strictEqual(ringkasan.postur.persenKategori.berat, 30);
    assert.ok(Math.abs(ringkasan.jantung.bpmRata - 75) < 1e-9);

    const csv = r.keCsv().split('\n');
    assert.strictEqual(csv.length, 101); // header + 100 baris
    assert.ok(csv[0].includes('bebanKerja') && csv[0].includes('postur_deviasi_derajat'));

    // Interpretasi: beban 60% tinggi → perhatian; postur berat 30% → perhatian
    const teks = M.interpretasi(ringkasan);
    assert.ok(teks.some((x) => x.tingkat === 'perhatian' && x.teks.includes('Beban kerja')), 'ada temuan beban kerja');
    assert.ok(teks.some((x) => x.teks.includes('RULA')), 'ada temuan postur RULA');
});

/* ===== interpretasi kondisi baik ===== */
uji('interpretasi sesi sehat memberi label baik', () => {
    const r = new M.PerekamSesi();
    r.mulai();
    for (let t = 1; t <= 50; t++) {
        r.tambah({
            t,
            indeks: { bebanKerja: 1, kelelahan: 1, fokus: 1, relaksasi: 0.3 },
            kategori: { bebanKerja: 'normal', kelelahan: 'normal', fokus: 'normal', relaksasi: 'normal' },
            kedipPerMenit: 14, posturDeviasi: 4, posturKategori: 'netral', bpm: 70, rmssd: 45,
        });
    }
    const teks = M.interpretasi(r.selesai());
    assert.ok(teks.filter((x) => x.tingkat === 'baik').length >= 2, 'minimal 2 temuan baik');
    assert.ok(!teks.some((x) => x.tingkat === 'perhatian'), 'tidak ada perhatian');
});

/* ===== fokus memakai betaRendah (13–22 Hz, Pope) bila tersedia ===== */
uji('indeks fokus memakai betaRendah bila ada', () => {
    const kanal = {
        AF7: { ...bp(1, 4, 2, 6, 1), betaRendah: 3 },
        AF8: { ...bp(1, 4, 2, 6, 1), betaRendah: 3 },
        TP9: bp(1, 2, 8, 4, 1),
        TP10: bp(1, 2, 8, 4, 1),
    };
    const idx = M.hitungIndeks(kanal);
    assert.ok(Math.abs(idx.fokus - 3 / (2 + 4)) < 1e-9, 'harus pakai betaRendah=3, bukan beta=6');
});

/* ===== gerbang |g| postur: sampel gerak dinamis dibuang ===== */
uji('postur mengabaikan sampel dengan |g| jauh dari 1', () => {
    const p = new M.PosturKepala();
    for (let i = 0; i < 60; i++) p.update({ x: 0, y: 1, z: 0 });
    p.setNetral();
    // guncangan: |a| = 2g ke arah z — harus diabaikan seluruhnya
    for (let i = 0; i < 300; i++) p.update({ x: 0, y: 0, z: 2 });
    const dev = p.deviasiDerajat();
    assert.ok(dev < 1, `deviasi ${dev}° padahal semua sampel guncangan harus dibuang`);
});

console.log(`\nSemua ${lulus} uji metrik LULUS`);
