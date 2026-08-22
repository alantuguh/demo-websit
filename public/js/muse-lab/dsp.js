/*
 * Muse Lab — modul DSP murni (tanpa dependensi).
 *
 * Dipakai di browser sebagai global `MuseDSP` dan di Node (untuk unit test)
 * lewat module.exports. Semua fungsi bebas efek samping kecuali kelas yang
 * memang menyimpan state (Biquad, RingBuffer).
 */
(function (root, factory) {
    if (typeof module === 'object' && module.exports) {
        module.exports = factory();
    } else {
        root.MuseDSP = factory();
    }
})(typeof self !== 'undefined' ? self : this, function () {
    'use strict';

    /* ===== Rentang band frekuensi EEG (Hz) ===== */
    const BANDS = {
        delta: [1, 4],
        theta: [4, 8],
        alpha: [8, 13],
        beta: [13, 30],
        gamma: [30, 44],
    };

    /* ===== Ring buffer float ===== */
    class RingBuffer {
        constructor(capacity) {
            this.buf = new Float64Array(capacity);
            this.capacity = capacity;
            this.length = 0;   // jumlah elemen terisi (maks = capacity)
            this.head = 0;     // posisi tulis berikutnya
            this.total = 0;    // total sampel yang pernah masuk
        }

        push(value) {
            this.buf[this.head] = value;
            this.head = (this.head + 1) % this.capacity;
            if (this.length < this.capacity) this.length++;
            this.total++;
        }

        pushAll(values) {
            for (let i = 0; i < values.length; i++) this.push(values[i]);
        }

        /** n sampel terakhir (array baru, urut lama → baru). */
        latest(n) {
            const count = Math.min(n, this.length);
            const out = new Float64Array(count);
            for (let i = 0; i < count; i++) {
                out[i] = this.buf[(this.head - count + i + this.capacity * 2) % this.capacity];
            }
            return out;
        }
    }

    /* ===== Filter biquad (RBJ cookbook) ===== */
    class Biquad {
        constructor(b0, b1, b2, a1, a2) {
            this.b0 = b0; this.b1 = b1; this.b2 = b2;
            this.a1 = a1; this.a2 = a2;
            this.x1 = 0; this.x2 = 0; this.y1 = 0; this.y2 = 0;
        }

        static notch(fs, f0, q) {
            const w0 = 2 * Math.PI * f0 / fs;
            const alpha = Math.sin(w0) / (2 * q);
            const cosw0 = Math.cos(w0);
            const a0 = 1 + alpha;
            return new Biquad(
                1 / a0, (-2 * cosw0) / a0, 1 / a0,
                (-2 * cosw0) / a0, (1 - alpha) / a0
            );
        }

        static lowpass(fs, f0, q) {
            const w0 = 2 * Math.PI * f0 / fs;
            const alpha = Math.sin(w0) / (2 * q);
            const cosw0 = Math.cos(w0);
            const a0 = 1 + alpha;
            return new Biquad(
                ((1 - cosw0) / 2) / a0, (1 - cosw0) / a0, ((1 - cosw0) / 2) / a0,
                (-2 * cosw0) / a0, (1 - alpha) / a0
            );
        }

        static highpass(fs, f0, q) {
            const w0 = 2 * Math.PI * f0 / fs;
            const alpha = Math.sin(w0) / (2 * q);
            const cosw0 = Math.cos(w0);
            const a0 = 1 + alpha;
            return new Biquad(
                ((1 + cosw0) / 2) / a0, (-(1 + cosw0)) / a0, ((1 + cosw0) / 2) / a0,
                (-2 * cosw0) / a0, (1 - alpha) / a0
            );
        }

        process(x) {
            const y = this.b0 * x + this.b1 * this.x1 + this.b2 * this.x2
                - this.a1 * this.y1 - this.a2 * this.y2;
            this.x2 = this.x1; this.x1 = x;
            this.y2 = this.y1; this.y1 = y;
            return y;
        }

        reset() { this.x1 = this.x2 = this.y1 = this.y2 = 0; }
    }

    /**
     * Rantai filter standar EEG: high-pass 1 Hz (buang drift DC),
     * low-pass 44 Hz, notch 50 Hz (jala-jala listrik Indonesia).
     */
    function makeEegFilterChain(fs) {
        const filters = [
            Biquad.highpass(fs, 1, 0.707),
            Biquad.lowpass(fs, 44, 0.707),
            Biquad.notch(fs, 50, 30),
        ];
        return {
            process(x) {
                let y = x;
                for (const f of filters) y = f.process(y);
                return y;
            },
            reset() { filters.forEach((f) => f.reset()); },
        };
    }

    /* ===== Jendela Hann (di-cache per ukuran) ===== */
    const hannCache = new Map();
    function hann(n) {
        let w = hannCache.get(n);
        if (!w) {
            w = new Float64Array(n);
            for (let i = 0; i < n; i++) {
                w[i] = 0.5 * (1 - Math.cos((2 * Math.PI * i) / (n - 1)));
            }
            hannCache.set(n, w);
        }
        return w;
    }

    /* ===== FFT radix-2 in-place (Cooley–Tukey) ===== */
    function fft(re, im) {
        const n = re.length;
        if ((n & (n - 1)) !== 0) throw new Error('Panjang FFT harus pangkat 2');

        // bit-reversal
        for (let i = 1, j = 0; i < n; i++) {
            let bit = n >> 1;
            for (; j & bit; bit >>= 1) j ^= bit;
            j ^= bit;
            if (i < j) {
                let t = re[i]; re[i] = re[j]; re[j] = t;
                t = im[i]; im[i] = im[j]; im[j] = t;
            }
        }

        for (let len = 2; len <= n; len <<= 1) {
            const ang = (-2 * Math.PI) / len;
            const wRe = Math.cos(ang), wIm = Math.sin(ang);
            for (let i = 0; i < n; i += len) {
                let curRe = 1, curIm = 0;
                for (let j = 0; j < len / 2; j++) {
                    const aRe = re[i + j], aIm = im[i + j];
                    const bRe = re[i + j + len / 2] * curRe - im[i + j + len / 2] * curIm;
                    const bIm = re[i + j + len / 2] * curIm + im[i + j + len / 2] * curRe;
                    re[i + j] = aRe + bRe; im[i + j] = aIm + bIm;
                    re[i + j + len / 2] = aRe - bRe; im[i + j + len / 2] = aIm - bIm;
                    const nextRe = curRe * wRe - curIm * wIm;
                    curIm = curRe * wIm + curIm * wRe;
                    curRe = nextRe;
                }
            }
        }
    }

    /**
     * PSD satu jendela (Hann, one-sided). Mengembalikan {freqs, psd}
     * dengan psd dalam satuan (unit²/Hz) relatif — cukup untuk rasio band.
     */
    function periodogram(samples, fs) {
        const n = samples.length;
        const w = hann(n);
        const re = new Float64Array(n);
        const im = new Float64Array(n);

        // Koreksi daya jendela: U = mean(w²)
        let u = 0;
        for (let i = 0; i < n; i++) {
            re[i] = samples[i] * w[i];
            u += w[i] * w[i];
        }
        u /= n;

        fft(re, im);

        const half = n / 2;
        const freqs = new Float64Array(half);
        const psd = new Float64Array(half);
        const scale = 1 / (fs * n * u);
        for (let k = 0; k < half; k++) {
            freqs[k] = (k * fs) / n;
            let p = (re[k] * re[k] + im[k] * im[k]) * scale;
            if (k > 0 && k < half) p *= 2; // one-sided
            psd[k] = p;
        }
        return { freqs, psd };
    }

    /**
     * PSD metode Welch: jendela `nfft` dengan overlap 50%, dirata-rata.
     * `samples` minimal sepanjang nfft; kalau kurang, null.
     */
    function welch(samples, fs, nfft) {
        if (samples.length < nfft) return null;
        const step = nfft / 2;
        let count = 0;
        let acc = null;
        let freqs = null;
        for (let start = 0; start + nfft <= samples.length; start += step) {
            const seg = samples.subarray
                ? samples.subarray(start, start + nfft)
                : samples.slice(start, start + nfft);
            const { freqs: f, psd } = periodogram(seg, fs);
            if (!acc) { acc = new Float64Array(psd.length); freqs = f; }
            for (let i = 0; i < psd.length; i++) acc[i] += psd[i];
            count++;
        }
        for (let i = 0; i < acc.length; i++) acc[i] /= count;
        return { freqs, psd: acc };
    }

    /** Daya absolut band [lo, hi) Hz dari hasil periodogram/welch. */
    function bandPower(spectrum, lo, hi) {
        const { freqs, psd } = spectrum;
        const df = freqs[1] - freqs[0];
        let p = 0;
        for (let i = 0; i < freqs.length; i++) {
            if (freqs[i] >= lo && freqs[i] < hi) p += psd[i] * df;
        }
        return p;
    }

    /**
     * Daya semua band standar dari satu deret sampel.
     * Mengembalikan {delta, theta, alpha, beta, gamma, betaRendah, total}
     * atau null bila sampel kurang dari nfft.
     *
     * betaRendah (13–22 Hz) TIDAK ikut dijumlahkan ke total karena tumpang
     * tindih dengan beta; ia dipakai khusus indeks engagement Pope dkk.
     * (1995) yang membatasi beta di 22 Hz untuk menghindari kontaminasi
     * EMG otot rahang — relevan di Muse karena TP9/TP10 dekat temporalis.
     */
    function bandPowers(samples, fs, nfft) {
        const spec = welch(samples, fs, nfft || 256);
        if (!spec) return null;
        const out = {};
        let total = 0;
        for (const [nama, [lo, hi]] of Object.entries(BANDS)) {
            out[nama] = bandPower(spec, lo, hi);
            total += out[nama];
        }
        out.total = total;
        out.betaRendah = bandPower(spec, 13, 22);
        return out;
    }

    /** Deviasi standar (dipakai indikator kualitas sinyal). */
    function std(samples) {
        const n = samples.length;
        if (n === 0) return 0;
        let mean = 0;
        for (let i = 0; i < n; i++) mean += samples[i];
        mean /= n;
        let acc = 0;
        for (let i = 0; i < n; i++) {
            const d = samples[i] - mean;
            acc += d * d;
        }
        return Math.sqrt(acc / n);
    }

    return { BANDS, RingBuffer, Biquad, makeEegFilterChain, hann, fft, periodogram, welch, bandPower, bandPowers, std };
});
