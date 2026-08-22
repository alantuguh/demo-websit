{{--
    Muse Lab — dashboard pemantauan EEG headband Muse dengan interpretasi
    neuro-ergonomi. Halaman berdiri sendiri (tanpa layout situs) karena ini
    instrumen layar penuh, seperti halaman VR.

    Mendukung Muse 2 / Muse S lama (MuseClient) dan Muse S Athena
    (MuseAthenaClient) lewat muse-jsx; deteksi protokol otomatis dari
    enumerasi characteristic GATT. Tanpa headband, Mode Demo membangkitkan
    sinyal sintetis sehingga seluruh pipeline tetap bisa dicoba.

    Logika ada di public/js/muse-lab/{dsp,metrics,charts,app}.js —
    dsp & metrics punya unit test di tests/js/.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muse Lab — Monitor Neuro-Ergonomi · LPSKE</title>
    <meta name="description" content="Pemantauan EEG Muse dengan interpretasi ergonomi: beban kerja mental, kelelahan, fokus, postur leher, dan detak jantung.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #060a13;
            --panel: rgba(13, 20, 38, 0.82);
            --panel-border: rgba(148, 163, 184, 0.16);
            --ink: #eaf2ff;
            --muted: #8fa3c8;
            --accent: #4f7df3;
            --aman: #22c55e;
            --waspada: #f59e0b;
            --bahaya: #ef4444;
            --mono: 'JetBrains Mono', ui-monospace, monospace;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background:
                radial-gradient(1100px 500px at 80% -10%, rgba(47, 95, 224, 0.16), transparent 60%),
                radial-gradient(900px 500px at 0% 110%, rgba(14, 116, 144, 0.14), transparent 60%),
                var(--bg);
            color: var(--ink);
            font-family: 'Space Grotesk', system-ui, sans-serif;
            min-height: 100vh;
        }

        a { color: var(--accent); }

        .wrap { max-width: 1240px; margin: 0 auto; padding: 18px 18px 60px; }

        /* ===== Header ===== */
        header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .kembali {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .kembali:hover { color: var(--ink); }

        h1 { font-size: 1.25rem; margin: 0; letter-spacing: -0.3px; }
        h1 small { color: var(--accent); font-size: 0.72rem; letter-spacing: 0.14em; text-transform: uppercase; display: block; }

        .chips { margin-left: auto; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--panel);
            border: 1px solid var(--panel-border);
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 0.8rem;
        }

        .dot { width: 9px; height: 9px; border-radius: 50%; background: #64748b; }
        .dot.siap { background: #64748b; }
        .dot.menghubungkan { background: var(--waspada); animation: kedip 1s infinite; }
        .dot.terhubung { background: var(--aman); }
        .dot.demo { background: var(--accent); }
        .dot.putus { background: var(--bahaya); }
        @keyframes kedip { 50% { opacity: 0.3; } }

        /* ===== Banner ===== */
        .banner {
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 0.86rem;
            margin-bottom: 12px;
        }
        .banner-galat { background: rgba(239, 68, 68, 0.14); border: 1px solid rgba(239, 68, 68, 0.45); }
        .banner-info { background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.4); }

        /* ===== Toolbar ===== */
        .toolbar { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin-bottom: 16px; }

        button {
            font-family: inherit;
            font-size: 0.85rem;
            font-weight: 700;
            border-radius: 10px;
            padding: 9px 16px;
            border: 1px solid var(--panel-border);
            background: var(--panel);
            color: var(--ink);
            cursor: pointer;
            transition: filter 0.15s ease, transform 0.15s ease;
        }
        button:hover:not(:disabled) { filter: brightness(1.25); }
        button:disabled { opacity: 0.45; cursor: not-allowed; }
        button.utama { background: linear-gradient(100deg, #2f5fe0, var(--accent)); border-color: transparent; }
        button.rekam { background: linear-gradient(100deg, #b91c1c, var(--bahaya)); border-color: transparent; }

        .toolbar .keterangan { font-size: 0.78rem; color: var(--muted); }

        /* ===== Grid panel ===== */
        .grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 14px; }

        .panel {
            background: var(--panel);
            border: 1px solid var(--panel-border);
            border-radius: 16px;
            padding: 14px 16px;
            backdrop-filter: blur(10px);
        }

        .panel h2 {
            margin: 0 0 10px;
            font-size: 0.78rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 700;
        }

        .p-eeg { grid-column: span 8; }
        .p-spektrum { grid-column: span 4; }
        .p-indeks { grid-column: span 12; }
        .p-dukung { grid-column: span 12; }
        .p-rekam { grid-column: span 12; }
        .p-panduan { grid-column: span 12; }

        @media (max-width: 900px) {
            .p-eeg, .p-spektrum { grid-column: span 12; }
        }

        /* ===== EEG ===== */
        .baris-eeg { display: grid; grid-template-columns: 84px 1fr; gap: 8px; align-items: center; margin-bottom: 6px; }
        .label-eeg { display: flex; align-items: center; gap: 8px; font-family: var(--mono); font-size: 0.78rem; }
        .kualitas { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .kualitas.putus { background: #475569; }
        .kualitas.lepas { background: #475569; outline: 2px solid var(--bahaya); }
        .kualitas.baik { background: var(--aman); }
        .kualitas.sedang { background: var(--waspada); }
        .kualitas.buruk { background: var(--bahaya); }
        .baris-eeg canvas { width: 100%; height: 64px; display: block; }

        #kanvas-spektrum { width: 100%; height: 286px; display: block; }

        /* ===== Kartu indeks ===== */
        .kartu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 12px; }

        .kartu {
            background: rgba(6, 10, 19, 0.5);
            border: 1px solid var(--panel-border);
            border-radius: 14px;
            padding: 12px 14px;
        }
        .kartu h3 { margin: 0; font-size: 0.86rem; }
        .kartu .sub { font-size: 0.7rem; color: var(--muted); margin: 2px 0 8px; }
        .kartu canvas { width: 100%; height: 74px; display: block; }
        .nilai-besar { font-family: var(--mono); font-size: 1.35rem; font-weight: 700; }
        .nilai-satuan { font-size: 0.75rem; color: var(--muted); }

        .chip-kategori {
            display: inline-block;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 10px;
            margin-top: 6px;
        }
        .chip-kategori.aman { background: rgba(34, 197, 94, 0.16); color: #6ee7a0; }
        .chip-kategori.waspada { background: rgba(245, 158, 11, 0.16); color: #fbbf24; }
        .chip-kategori.bahaya { background: rgba(239, 68, 68, 0.18); color: #fca5a5; }
        .chip-kategori.kosong { background: rgba(148, 163, 184, 0.14); color: var(--muted); }

        /* ===== Rekam & laporan ===== */
        .form-baris { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
        input[type="text"] {
            font-family: inherit;
            font-size: 0.85rem;
            background: rgba(6, 10, 19, 0.6);
            border: 1px solid var(--panel-border);
            border-radius: 10px;
            color: var(--ink);
            padding: 8px 12px;
            min-width: 180px;
        }
        input[type="text"]:focus { outline: none; border-color: var(--accent); }

        #rekam-timer { font-family: var(--mono); font-size: 1.1rem; font-weight: 700; }

        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; margin: 8px 0; }
        th, td { text-align: left; padding: 6px 10px; border-bottom: 1px solid var(--panel-border); }
        th { color: var(--muted); font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; }

        .lapor-chip {
            display: inline-block;
            background: rgba(6, 10, 19, 0.55);
            border: 1px solid var(--panel-border);
            border-radius: 999px;
            font-size: 0.78rem;
            padding: 5px 12px;
            margin: 3px 6px 3px 0;
        }

        .tl-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 12px; margin-top: 10px; }
        .tl-grid canvas { width: 100%; height: 110px; display: block; }
        .tl-grid p { margin: 4px 0 0; font-size: 0.72rem; color: var(--muted); }

        #laporan-interpretasi { margin: 8px 0 0; padding-left: 0; list-style: none; }
        #laporan-interpretasi li {
            border-left: 3px solid var(--muted);
            padding: 7px 12px;
            margin-bottom: 7px;
            font-size: 0.86rem;
            background: rgba(6, 10, 19, 0.45);
            border-radius: 0 10px 10px 0;
        }
        li.interpretasi-baik { border-left-color: var(--aman) !important; }
        li.interpretasi-info { border-left-color: var(--waspada) !important; }
        li.interpretasi-perhatian { border-left-color: var(--bahaya) !important; }

        /* ===== Panduan ===== */
        details summary { cursor: pointer; font-weight: 700; font-size: 0.9rem; }
        details p, details li { font-size: 0.85rem; color: var(--muted); line-height: 1.65; }
        details b { color: var(--ink); }

        .disclaimer { font-size: 0.75rem; color: var(--muted); margin-top: 18px; text-align: center; }
    </style>
</head>
<body>
<div class="wrap">

    {{-- ===== Header ===== --}}
    <header>
        <a class="kembali" href="{{ route('home') }}">&larr; LPSKE</a>
        <h1><small>Muse Lab</small> Monitor Neuro-Ergonomi</h1>
        <div class="chips">
            <span class="chip"><span class="dot siap" id="status-dot"></span><span id="status-teks">Belum terhubung</span></span>
            <span class="chip">Perangkat: <b id="info-perangkat">—</b></span>
            <span class="chip" id="chip-baterai" style="display:none;">🔋 <b id="info-baterai">—</b></span>
        </div>
    </header>

    <div class="banner banner-galat" id="galat" style="display:none;"></div>
    <div class="banner banner-info" id="peringatan-browser" style="display:none;">
        Browser ini tidak punya Web Bluetooth (Firefox/Safari/iOS tidak mendukung) — koneksi headband
        tidak tersedia, tetapi <b>Mode Demo</b> tetap bisa dijalankan. Untuk perangkat asli pakai
        Chrome/Edge di Windows, macOS, Linux, atau Android.
    </div>

    {{-- ===== Toolbar ===== --}}
    <div class="toolbar">
        <button class="utama" id="tombol-hubungkan">Hubungkan Muse</button>
        <button id="tombol-demo">Mode Demo (tanpa perangkat)</button>
        <button id="tombol-putuskan" style="display:none;">Putuskan</button>
        <button id="tombol-kalibrasi" disabled>Kalibrasi Baseline (60 dtk)</button>
        <button id="tombol-netral" disabled>Set Postur Netral</button>
        <span class="keterangan" id="status-kalibrasi"></span>
    </div>
    <div class="toolbar">
        <span class="keterangan" id="info-baseline"></span>
    </div>

    {{-- ===== Grid utama ===== --}}
    <div class="grid">

        {{-- EEG mentah --}}
        <section class="panel p-eeg">
            <h2>Sinyal EEG (terfilter 1–44 Hz, notch 50 Hz)</h2>
            @foreach (['TP9' => 'telinga kiri', 'AF7' => 'dahi kiri', 'AF8' => 'dahi kanan', 'TP10' => 'telinga kanan'] as $kanal => $letak)
                <div class="baris-eeg">
                    <span class="label-eeg" title="{{ $letak }}">
                        <span class="kualitas putus" id="kualitas-{{ $kanal }}"></span>{{ $kanal }}
                    </span>
                    <canvas id="gelombang-{{ $kanal }}"></canvas>
                </div>
            @endforeach
        </section>

        {{-- Spektrum --}}
        <section class="panel p-spektrum">
            <h2>Distribusi Band Frekuensi</h2>
            <canvas id="kanvas-spektrum"></canvas>
        </section>

        {{-- Indeks neuro-ergonomi --}}
        <section class="panel p-indeks">
            <h2>Indeks Neuro-Ergonomi <span style="text-transform:none; letter-spacing:0;">(relatif baseline personal)</span></h2>
            <div class="kartu-grid">
                <div class="kartu">
                    <h3>Beban Kerja Mental</h3>
                    <p class="sub">θ frontal / α posterior — Gevins &amp; Smith</p>
                    <canvas id="gauge-bebanKerja"></canvas>
                    <span class="nilai-besar" id="nilai-bebanKerja">—</span>
                    <div><span class="chip-kategori kosong" id="kategori-bebanKerja">—</span></div>
                </div>
                <div class="kartu">
                    <h3>Kelelahan / Kantuk</h3>
                    <p class="sub">(θ + α) / β — Jap dkk.</p>
                    <canvas id="gauge-kelelahan"></canvas>
                    <span class="nilai-besar" id="nilai-kelelahan">—</span>
                    <div><span class="chip-kategori kosong" id="kategori-kelelahan">—</span></div>
                </div>
                <div class="kartu">
                    <h3>Fokus / Engagement</h3>
                    <p class="sub">β(13–22) / (α + θ) — Pope dkk.</p>
                    <canvas id="gauge-fokus"></canvas>
                    <span class="nilai-besar" id="nilai-fokus">—</span>
                    <div><span class="chip-kategori kosong" id="kategori-fokus">—</span></div>
                </div>
                <div class="kartu">
                    <h3>Relaksasi</h3>
                    <p class="sub">α relatif terhadap daya total</p>
                    <canvas id="gauge-relaksasi"></canvas>
                    <span class="nilai-besar" id="nilai-relaksasi">—</span>
                    <div><span class="chip-kategori kosong" id="kategori-relaksasi">—</span></div>
                </div>
            </div>
        </section>

        {{-- Indikator pendukung --}}
        <section class="panel p-dukung">
            <h2>Indikator Pendukung</h2>
            <div class="kartu-grid">
                <div class="kartu">
                    <h3>Kedipan Mata</h3>
                    <p class="sub">artefak okuler AF7 — kelelahan visual</p>
                    <span class="nilai-besar" id="nilai-kedip">—</span>
                    <p class="sub" style="margin-top:6px;">Normal ±10–20/menit. &lt;8: menatap layar terlalu intens · &gt;25: ikut menandai lelah.</p>
                </div>
                <div class="kartu">
                    <h3>Postur Kepala / Leher</h3>
                    <p class="sub">accelerometer headband — deviasi dari netral</p>
                    <span class="nilai-besar" id="nilai-postur">—</span>
                    <div><span class="chip-kategori kosong" id="kategori-postur">—</span></div>
                    <p class="sub" style="margin-top:6px;" id="nilai-postur-skor">Kalibrasi netral dulu</p>
                </div>
                <div class="kartu" id="kartu-jantung" style="display:none;">
                    <h3>Detak Jantung (PPG/optik)</h3>
                    <p class="sub">sensor optik dahi — stres fisiologis</p>
                    <span class="nilai-besar" id="nilai-bpm">—</span> <span class="nilai-satuan">bpm</span>
                    <p class="sub" style="margin-top:6px;">HRV (RMSSD): <b id="nilai-rmssd">—</b> — makin rendah dari kebiasaan, makin tegang.</p>
                </div>
            </div>
        </section>

        {{-- Rekam sesi + laporan --}}
        <section class="panel p-rekam">
            <h2>Rekam Sesi &amp; Laporan</h2>
            <div class="form-baris">
                <input type="text" id="input-subjek" placeholder="Nama subjek *" maxlength="100">
                <input type="text" id="input-aktivitas" placeholder="Aktivitas (mis. mengetik, menyetir simulator)" maxlength="150">
                <button class="rekam" id="tombol-rekam" disabled>&#9679; Mulai Rekam</button>
                <button class="rekam" id="tombol-stop" style="display:none;">&#9632; Selesai</button>
                <span id="rekam-timer">0:00</span>
                <span class="keterangan" id="rekam-status"></span>
            </div>

            <div id="panel-laporan" style="display:none; margin-top:14px;">
                <p class="keterangan" id="laporan-meta"></p>

                <table>
                    <thead><tr><th>Indeks</th><th>Rata-rata</th><th>Maks</th><th>Distribusi kategori</th></tr></thead>
                    <tbody id="laporan-tabel"></tbody>
                </table>

                <div id="laporan-lain"></div>

                <div class="tl-grid">
                    <div><canvas id="tl-beban"></canvas><p>Beban kerja mental sepanjang sesi (putus-putus = baseline)</p></div>
                    <div><canvas id="tl-lelah"></canvas><p>Indeks kelelahan sepanjang sesi</p></div>
                    <div><canvas id="tl-postur"></canvas><p>Deviasi postur leher (derajat; acuan 10°)</p></div>
                </div>

                <h2 style="margin-top:14px;">Interpretasi Ergonomi Otomatis</h2>
                <ul id="laporan-interpretasi"></ul>

                <div class="form-baris" style="margin-top:10px;">
                    <button id="tombol-csv">Unduh CSV (data per detik)</button>
                    <button class="utama" id="tombol-simpan">Simpan Ringkasan ke Server</button>
                    <span class="keterangan" id="simpan-status"></span>
                </div>
            </div>
        </section>

        {{-- Panduan --}}
        <section class="panel p-panduan">
            <details>
                <summary>Panduan pemakaian &amp; catatan metode</summary>
                <p><b>Menyiapkan headband:</b> basahi sedikit kulit di belakang telinga dan dahi, pasang Muse hingga keempat titik kualitas sinyal hijau. Duduk tenang — mengunyah, mengernyit, dan bicara membuat artefak otot.</p>
                <p><b>Urutan kerja yang disarankan:</b> ① Hubungkan (atau Mode Demo) → ② duduk santai lalu <b>Kalibrasi Baseline 60 detik</b> (sekaligus merekam postur netral) → ③ mulai aktivitas yang mau dinilai sambil <b>Rekam Sesi</b> → ④ selesai, baca laporan &amp; interpretasi, unduh CSV atau simpan ringkasannya.</p>
                <p><b>Perangkat:</b> Muse 2 dan Muse S lama memakai protokol klasik (termasuk PPG detak jantung); <b>Muse S Athena</b> terdeteksi otomatis dan memakai protokol barunya (detak jantung dihitung dari sensor optik fNIRS-nya). Jika Athena tidak mengirim data: tutup total aplikasi Muse resmi/Mind Monitor di HP — Athena hanya melayani satu koneksi.</p>
                <p><b>Metode:</b> band power dihitung dengan Welch (jendela Hann 1 dtk, tumpang-tindih 50%) dari sinyal terfilter 1–44 Hz + notch 50 Hz. Indeks: beban kerja = θ<sub>AF7,AF8</sub>/α<sub>TP9,TP10</sub> (Gevins &amp; Smith 2003); kelelahan = (θ+α)/β (Jap dkk. 2009); engagement = β<sub>13–22</sub>/(α+θ) (Pope dkk. 1995, batas 22 Hz menghindari EMG); relaksasi = α relatif. Kategori dihitung <b>relatif terhadap baseline pribadi</b> karena nilai absolut EEG sangat bervariasi antar orang. Postur leher memakai ambang RULA (10°/20°). Kedipan dideteksi dari artefak okuler AF7. Detak jantung dari puncak PPG dengan interpolasi sub-sampel; HRV memakai RMSSD.</p>
                <p><b>Privasi:</b> semua pemrosesan terjadi di browser Anda. Server hanya menerima ringkasan sesi bila Anda menekan "Simpan ke Server". Data mentah bisa diunduh sebagai CSV.</p>
            </details>
        </section>
    </div>

    <p class="disclaimer">
        Muse Lab adalah alat bantu edukasi &amp; penelitian ergonomi LPSKE — bukan alat diagnosis medis.
        Interpretasi otomatis bersifat indikatif dan tidak menggantikan penilaian profesional.
    </p>
</div>

<script>
    window.MUSE_LAB_CONFIG = {
        simpanUrl: @json(route('muse-lab.sesi')),
        csrf: @json(csrf_token()),
    };
</script>
<script src="{{ asset('js/muse-lab/dsp.js') }}?v=1"></script>
<script src="{{ asset('js/muse-lab/metrics.js') }}?v=1"></script>
<script src="{{ asset('js/muse-lab/charts.js') }}?v=1"></script>
<script type="module" src="{{ asset('js/muse-lab/app.js') }}?v=1"></script>
</body>
</html>
