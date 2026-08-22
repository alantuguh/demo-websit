/*
 * Muse Lab — renderer canvas 2D murni (tanpa library chart).
 * Browser-only; global `MuseCharts`.
 *
 * Semua renderer membaca ukuran CSS elemen kanvas saat menggambar dan
 * menyesuaikan backing store dengan devicePixelRatio supaya tetap tajam.
 */
(function (root) {
    'use strict';

    /** Samakan backing store kanvas dengan ukuran CSS × devicePixelRatio. */
    function siapkan(canvas) {
        const dpr = window.devicePixelRatio || 1;
        const w = canvas.clientWidth;
        const h = canvas.clientHeight;
        if (w === 0 || h === 0) return null;
        if (canvas.width !== Math.round(w * dpr) || canvas.height !== Math.round(h * dpr)) {
            canvas.width = Math.round(w * dpr);
            canvas.height = Math.round(h * dpr);
        }
        const ctx = canvas.getContext('2d');
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        return { ctx, w, h };
    }

    /* =====================================================================
     * Gelombang EEG bergulir. Decimasi min/max per kolom piksel supaya
     * 256 Hz × beberapa detik tetap ringan digambar 60 fps.
     * =================================================================== */
    class Gelombang {
        constructor(canvas, opsi) {
            this.canvas = canvas;
            this.detik = (opsi && opsi.detik) || 4;
            this.fs = (opsi && opsi.fs) || 256;
            this.warna = (opsi && opsi.warna) || '#4f7df3';
            this.warnaGaris = (opsi && opsi.warnaGaris) || 'rgba(148, 163, 184, 0.18)';
            this.skala = 60; // µV penuh-layar awal; adaptif pelan-pelan
        }

        gambar(ring) {
            const c = siapkan(this.canvas);
            if (!c) return;
            const { ctx, w, h } = c;

            ctx.clearRect(0, 0, w, h);

            // garis tengah
            ctx.strokeStyle = this.warnaGaris;
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(0, h / 2);
            ctx.lineTo(w, h / 2);
            ctx.stroke();

            const n = Math.min(this.detik * this.fs, ring.length);
            if (n < 8) return;
            const data = ring.latest(n);

            // skala adaptif: kejar amplitudo p95 pelan-pelan
            let maksAbs = 1;
            for (let i = 0; i < data.length; i++) {
                const a = Math.abs(data[i]);
                if (a > maksAbs) maksAbs = a;
            }
            const target = Math.min(300, Math.max(20, maksAbs * 1.2));
            this.skala += 0.05 * (target - this.skala);

            const perPiksel = data.length / w;
            ctx.strokeStyle = this.warna;
            ctx.lineWidth = 1.4;
            ctx.beginPath();

            if (perPiksel <= 1) {
                for (let i = 0; i < data.length; i++) {
                    const x = (i / (data.length - 1)) * w;
                    const y = h / 2 - (data[i] / this.skala) * (h / 2);
                    if (i === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
                }
            } else {
                // min/max per kolom piksel
                for (let x = 0; x < w; x++) {
                    const mulai = Math.floor(x * perPiksel);
                    const akhir = Math.min(data.length, Math.floor((x + 1) * perPiksel) + 1);
                    let lo = Infinity, hi = -Infinity;
                    for (let i = mulai; i < akhir; i++) {
                        if (data[i] < lo) lo = data[i];
                        if (data[i] > hi) hi = data[i];
                    }
                    const yLo = h / 2 - (lo / this.skala) * (h / 2);
                    const yHi = h / 2 - (hi / this.skala) * (h / 2);
                    ctx.moveTo(x + 0.5, yLo);
                    ctx.lineTo(x + 0.5, yHi);
                }
            }
            ctx.stroke();
        }
    }

    /* =====================================================================
     * Spektrum band: 5 batang delta..gamma (proporsi relatif).
     * =================================================================== */
    const BAND_META = [
        ['delta', 'δ 1-4', '#818cf8'],
        ['theta', 'θ 4-8', '#38bdf8'],
        ['alpha', 'α 8-13', '#34d399'],
        ['beta', 'β 13-30', '#fbbf24'],
        ['gamma', 'γ 30-44', '#f87171'],
    ];

    class Spektrum {
        constructor(canvas, opsi) {
            this.canvas = canvas;
            this.warnaTeks = (opsi && opsi.warnaTeks) || '#b9c8e8';
            this.halus = {}; // nilai ter-lowpass supaya animasi lembut
        }

        gambar(bp) {
            const c = siapkan(this.canvas);
            if (!c) return;
            const { ctx, w, h } = c;
            ctx.clearRect(0, 0, w, h);
            if (!bp || !bp.total) return;

            const labelH = 18;
            const lebarSlot = w / BAND_META.length;
            ctx.font = '11px "Space Grotesk", system-ui, sans-serif';
            ctx.textAlign = 'center';

            for (let i = 0; i < BAND_META.length; i++) {
                const [kunci, label, warna] = BAND_META[i];
                const proporsi = Math.max(0, Math.min(1, (bp[kunci] || 0) / bp.total));
                const sebelum = this.halus[kunci] === undefined ? proporsi : this.halus[kunci];
                const nilai = sebelum + 0.25 * (proporsi - sebelum);
                this.halus[kunci] = nilai;

                const tinggiBar = nilai * (h - labelH - 6);
                const x = i * lebarSlot + lebarSlot * 0.18;
                const lebarBar = lebarSlot * 0.64;

                ctx.fillStyle = warna;
                ctx.globalAlpha = 0.92;
                ctx.beginPath();
                ctx.roundRect(x, h - labelH - tinggiBar, lebarBar, tinggiBar, 4);
                ctx.fill();
                ctx.globalAlpha = 1;

                ctx.fillStyle = this.warnaTeks;
                ctx.fillText(label, i * lebarSlot + lebarSlot / 2, h - 4);
                ctx.fillText(Math.round(nilai * 100) + '%', i * lebarSlot + lebarSlot / 2, h - labelH - tinggiBar - 5);
            }
        }
    }

    /* =====================================================================
     * Gauge setengah lingkaran untuk indeks vs baseline (rasio 0..2).
     * Zona diwarnai sesuai arah indeks (naikBuruk).
     * =================================================================== */
    class Gauge {
        constructor(canvas, opsi) {
            this.canvas = canvas;
            this.naikBuruk = !!(opsi && opsi.naikBuruk);
            this.batasTurun = (opsi && opsi.batasTurun) || 0.75;
            this.batasNaik = (opsi && opsi.batasNaik) || 1.35;
            this.halus = 1;
        }

        gambar(rasio) {
            const c = siapkan(this.canvas);
            if (!c) return;
            const { ctx, w, h } = c;
            ctx.clearRect(0, 0, w, h);

            const cx = w / 2;
            const cy = h * 0.92;
            const r = Math.min(w / 2, h * 0.84) - 6;
            const keSudut = (v) => Math.PI + (Math.min(2, Math.max(0, v)) / 2) * Math.PI;

            // Palet zona: hijau = aman, kuning = waspada, merah = perhatian
            const HIJAU = 'rgba(34, 197, 94, 0.75)';
            const KUNING = 'rgba(245, 158, 11, 0.75)';
            const MERAH = 'rgba(239, 68, 68, 0.75)';
            const zona = this.naikBuruk
                ? [[0, this.batasTurun, KUNING], [this.batasTurun, this.batasNaik, HIJAU], [this.batasNaik, 2, MERAH]]
                : [[0, this.batasTurun, KUNING], [this.batasTurun, this.batasNaik, HIJAU], [this.batasNaik, 2, HIJAU]];

            ctx.lineWidth = 9;
            ctx.lineCap = 'butt';
            for (const [dari, sampai, warna] of zona) {
                ctx.strokeStyle = warna;
                ctx.beginPath();
                ctx.arc(cx, cy, r, keSudut(dari), keSudut(sampai));
                ctx.stroke();
            }

            if (rasio === null || !isFinite(rasio)) {
                ctx.fillStyle = '#8fa3c8';
                ctx.font = '12px "Space Grotesk", system-ui, sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText('—', cx, cy - r / 2);
                return;
            }

            this.halus += 0.15 * (rasio - this.halus);

            // jarum
            const sudut = keSudut(this.halus);
            ctx.strokeStyle = '#eaf2ff';
            ctx.lineWidth = 3;
            ctx.lineCap = 'round';
            ctx.beginPath();
            ctx.moveTo(cx, cy);
            ctx.lineTo(cx + Math.cos(sudut) * (r - 12), cy + Math.sin(sudut) * (r - 12));
            ctx.stroke();
            ctx.fillStyle = '#eaf2ff';
            ctx.beginPath();
            ctx.arc(cx, cy, 4, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    /* =====================================================================
     * Garis waktu metrik sesi (untuk laporan setelah rekaman).
     * =================================================================== */
    class GarisWaktu {
        constructor(canvas, opsi) {
            this.canvas = canvas;
            this.warna = (opsi && opsi.warna) || '#4f7df3';
            this.warnaTeks = (opsi && opsi.warnaTeks) || '#8fa3c8';
        }

        /** titik: array {t, v}; garisAcuan: nilai baseline opsional. */
        gambar(titik, garisAcuan) {
            const c = siapkan(this.canvas);
            if (!c) return;
            const { ctx, w, h } = c;
            ctx.clearRect(0, 0, w, h);

            const data = titik.filter((p) => p.v !== null && isFinite(p.v));
            if (data.length < 2) {
                ctx.fillStyle = this.warnaTeks;
                ctx.font = '12px "Space Grotesk", system-ui, sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText('Data tidak cukup', w / 2, h / 2);
                return;
            }

            const pad = { atas: 8, bawah: 18, kiri: 8, kanan: 8 };
            const tMaks = data[data.length - 1].t;
            let vLo = Infinity, vHi = -Infinity;
            for (const p of data) {
                if (p.v < vLo) vLo = p.v;
                if (p.v > vHi) vHi = p.v;
            }
            if (garisAcuan !== undefined && garisAcuan !== null) {
                vLo = Math.min(vLo, garisAcuan);
                vHi = Math.max(vHi, garisAcuan);
            }
            const rentang = vHi - vLo || 1;
            vLo -= rentang * 0.1;
            vHi += rentang * 0.1;

            const X = (t) => pad.kiri + (t / tMaks) * (w - pad.kiri - pad.kanan);
            const Y = (v) => pad.atas + (1 - (v - vLo) / (vHi - vLo)) * (h - pad.atas - pad.bawah);

            if (garisAcuan !== undefined && garisAcuan !== null) {
                ctx.strokeStyle = 'rgba(148, 163, 184, 0.4)';
                ctx.setLineDash([4, 4]);
                ctx.beginPath();
                ctx.moveTo(pad.kiri, Y(garisAcuan));
                ctx.lineTo(w - pad.kanan, Y(garisAcuan));
                ctx.stroke();
                ctx.setLineDash([]);
            }

            ctx.strokeStyle = this.warna;
            ctx.lineWidth = 1.8;
            ctx.beginPath();
            data.forEach((p, i) => {
                if (i === 0) ctx.moveTo(X(p.t), Y(p.v));
                else ctx.lineTo(X(p.t), Y(p.v));
            });
            ctx.stroke();

            // label sumbu waktu
            ctx.fillStyle = this.warnaTeks;
            ctx.font = '10px "Space Grotesk", system-ui, sans-serif';
            ctx.textAlign = 'left';
            ctx.fillText('0', pad.kiri, h - 5);
            ctx.textAlign = 'right';
            const menit = Math.floor(tMaks / 60);
            const dtk = Math.round(tMaks % 60);
            ctx.fillText(menit + 'm ' + dtk + 's', w - pad.kanan, h - 5);
        }
    }

    root.MuseCharts = { siapkan, Gelombang, Spektrum, Gauge, GarisWaktu, BAND_META };
})(typeof self !== 'undefined' ? self : this);
