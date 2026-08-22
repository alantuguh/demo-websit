/*
 * Unit test modul DSP Muse Lab. Jalankan: node tests/js/dsp.test.cjs
 * Tanpa framework — assert bawaan Node supaya bisa jalan di mana saja.
 */
const assert = require('node:assert');
const DSP = require('../../public/js/muse-lab/dsp.js');

const FS = 256;

function sine(freq, n, amp = 1, fs = FS) {
    const out = new Float64Array(n);
    for (let i = 0; i < n; i++) out[i] = amp * Math.sin((2 * Math.PI * freq * i) / fs);
    return out;
}

let lulus = 0;
function uji(nama, fn) {
    fn();
    lulus++;
    console.log('OK  ' + nama);
}

/* ===== Band power: sinus murni harus jatuh di band yang benar ===== */
for (const [band, freq] of [['delta', 2.5], ['theta', 6], ['alpha', 10], ['beta', 20], ['gamma', 35]]) {
    uji(`sinus ${freq} Hz dominan di band ${band}`, () => {
        const bp = DSP.bandPowers(sine(freq, 1024), FS, 256);
        assert.ok(bp, 'bandPowers null');
        assert.ok(bp[band] / bp.total > 0.85,
            `${band} hanya ${(100 * bp[band] / bp.total).toFixed(1)}% dari total`);
    });
}

/* ===== Parseval: daya sinus amplitudo A = A²/2 ===== */
uji('daya band sesuai Parseval (±12%)', () => {
    const amp = 40; // µV
    const bp = DSP.bandPowers(sine(10, 2048, amp), FS, 256);
    const teoretis = (amp * amp) / 2;
    assert.ok(Math.abs(bp.alpha - teoretis) / teoretis < 0.12,
        `alpha=${bp.alpha.toFixed(1)}, teoretis=${teoretis}`);
});

/* ===== Notch 50 Hz meredam jala-jala ===== */
uji('rantai filter meredam 50 Hz > 20x', () => {
    const chain = DSP.makeEegFilterChain(FS);
    const masuk = sine(50, 2048, 100);
    const keluar = new Float64Array(2048);
    for (let i = 0; i < masuk.length; i++) keluar[i] = chain.process(masuk[i]);
    // buang transien awal
    const stabil = keluar.slice(1024);
    assert.ok(DSP.std(stabil) < DSP.std(masuk.slice(1024)) / 20,
        `std keluar=${DSP.std(stabil).toFixed(2)} vs masuk=${DSP.std(masuk.slice(1024)).toFixed(2)}`);
});

/* ===== High-pass membuang offset DC ===== */
uji('rantai filter membuang offset DC', () => {
    const chain = DSP.makeEegFilterChain(FS);
    const keluar = [];
    for (let i = 0; i < 2048; i++) keluar.push(chain.process(800 + 10 * Math.sin((2 * Math.PI * 10 * i) / FS)));
    const stabil = keluar.slice(1024);
    const rata = stabil.reduce((a, b) => a + b, 0) / stabil.length;
    assert.ok(Math.abs(rata) < 1, `rata-rata sisa DC = ${rata.toFixed(3)}`);
});

/* ===== Sinyal 10 Hz selamat melewati rantai filter ===== */
uji('sinyal alpha 10 Hz lolos rantai filter (>70% amplitudo)', () => {
    const chain = DSP.makeEegFilterChain(FS);
    const masuk = sine(10, 2048, 50);
    const keluar = new Float64Array(2048);
    for (let i = 0; i < masuk.length; i++) keluar[i] = chain.process(masuk[i]);
    assert.ok(DSP.std(keluar.slice(1024)) > DSP.std(masuk.slice(1024)) * 0.7);
});

/* ===== RingBuffer ===== */
uji('RingBuffer menyimpan sampel terakhir dengan urutan benar', () => {
    const rb = new DSP.RingBuffer(8);
    for (let i = 1; i <= 20; i++) rb.push(i);
    assert.deepStrictEqual(Array.from(rb.latest(4)), [17, 18, 19, 20]);
    assert.strictEqual(rb.length, 8);
    assert.strictEqual(rb.total, 20);
});

/* ===== FFT menolak panjang bukan pangkat 2 ===== */
uji('FFT menolak panjang bukan pangkat 2', () => {
    assert.throws(() => DSP.fft(new Float64Array(100), new Float64Array(100)));
});

console.log(`\nSemua ${lulus} uji DSP LULUS`);
