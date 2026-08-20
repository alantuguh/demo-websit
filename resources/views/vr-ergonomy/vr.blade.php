{{--
    Scene VR multiplayer satu ruang VR Ergonomy Lab.

    Halaman HTML penuh yang berdiri sendiri (tidak memakai layout situs)
    karena A-Frame menguasai seluruh layar. Dibangun dengan:
      - A-Frame 1.7.0                — engine WebXR di atas three.js
      - Networked-A-Frame 0.14.3    — sinkronisasi avatar antar pengunjung
        lewat adapter "socketio"; servernya ada di vr-server/ (jalankan
        `npm run vr-server`). Tanpa server, halaman jatuh ke mode solo.
      - aframe-extras (controls)    — movement-controls: WASD, sentuh, dan
        thumbstick controller VR.

    Geometri ruang seluruhnya primitif A-Frame (tanpa model GLTF) supaya
    tidak ada aset yang harus di-build atau diunggah; warna aksen tiap
    ruang diambil dari kolom vr_rooms.warna.
--}}
@php
    $accent = $room->warna ?: '#2f5fe0';

    // Isi papan dinding. Baris dipendekkan supaya tidak menabrak tepi papan;
    // teks multi-baris disuntikkan lewat JS (atribut HTML tidak mengenal \n).
    $capaianLines = collect($room->capaian ?? [])
        ->take(6)
        ->map(fn ($c) => '- ' . Str::limit($c, 58))
        ->implode("\n") ?: 'Capaian pembelajaran ruang ini belum ditetapkan.';

    $modulLines = $modules
        ->take(8)
        ->map(function ($m) use ($levelOptions) {
            $level = $levelOptions[$m->level] ?? $m->level;
            return '- ' . Str::limit($m->judul, 38) . '  (' . $level . ')';
        })
        ->implode("\n") ?: 'Modul untuk ruang ini sedang disiapkan.';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $room->nama }} — VR Ergonomy Lab · LPSKE</title>
    <meta name="description" content="Masuk ke {{ $room->nama }} — ruang VR multiplayer LPSKE.">
    <meta name="robots" content="noindex">

    <script src="https://aframe.io/releases/1.7.0/aframe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/c-frame/aframe-extras@7.5.4/dist/aframe-extras.controls.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.8.1/socket.io.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/networked-aframe@0.14.3/dist/networked-aframe.min.js"></script>

    <script>
        /* ============ Skema sinkronisasi Networked-A-Frame ============
           Pola pembungkusan getComponents ini mengikuti contoh resmi NAF
           (examples/basic.html) sebagai mitigasi issue #267 mereka. */
        NAF.schemas.getComponentsOriginal = NAF.schemas.getComponents;
        NAF.schemas.getComponents = (template) => {
            if (!NAF.schemas.hasTemplate('#avatar-template')) {
                NAF.schemas.add({
                    template: '#avatar-template',
                    components: [
                        { component: 'position', requiresNetworkUpdate: NAF.utils.vectorRequiresUpdate(0.001) },
                        { component: 'rotation', requiresNetworkUpdate: NAF.utils.vectorRequiresUpdate(0.5) },
                        // Satu komponen kecil yang membawa nama + warna avatar,
                        // sehingga keduanya ikut tersinkron ke pemain lain.
                        'player-info'
                    ]
                });
            }
            if (!NAF.schemas.hasTemplate('#rig-template')) {
                NAF.schemas.add({
                    template: '#rig-template',
                    components: [
                        { component: 'position', requiresNetworkUpdate: NAF.utils.vectorRequiresUpdate(0.001) },
                        { component: 'rotation', requiresNetworkUpdate: NAF.utils.vectorRequiresUpdate(0.5) }
                    ]
                });
            }
            return NAF.schemas.getComponentsOriginal(template);
        };

        /* ============ Komponen A-Frame khusus halaman ini ============ */

        const WARNA_AVATAR = ['#4f7df3', '#22c55e', '#f59e0b', '#ef4444', '#a855f7', '#06b6d4', '#ec4899', '#84cc16'];

        // Nama + warna avatar. Dipasang pada #player lokal (sumber data yang
        // disinkronkan NAF) dan pada akar template avatar (penerima di sisi
        // pemain lain). update() menyalin data ke anak .head dan .nametag.
        AFRAME.registerComponent('player-info', {
            schema: {
                name:  { type: 'string', default: '' },
                color: { type: 'color',  default: '#9fb3d8' }
            },

            init() {
                if (this.el.id === 'player') {
                    const nama = sessionStorage.getItem('lpske-vr-nama')
                        || 'Praktikan-' + (100 + Math.floor(Math.random() * 900));
                    const warna = sessionStorage.getItem('lpske-vr-warna')
                        || WARNA_AVATAR[Math.floor(Math.random() * WARNA_AVATAR.length)];
                    sessionStorage.setItem('lpske-vr-nama', nama);
                    sessionStorage.setItem('lpske-vr-warna', warna);
                    this.el.setAttribute('player-info', { name: nama, color: warna });

                    const input = document.getElementById('name-input');
                    if (input) input.value = nama;
                }
            },

            update() {
                // Anak-anak berasal dari template yang dipasang NAF; saat
                // update pertama bisa saja belum terpasang, maka dicari ulang.
                if (!this.head)    this.head    = this.el.querySelector('.head');
                if (!this.nametag) this.nametag = this.el.querySelector('.nametag');
                if (this.head)    this.head.setAttribute('color', this.data.color);
                if (this.nametag) this.nametag.setAttribute('value', this.data.name);
            }
        });

        // Sebar titik lahir pemain di lingkaran mengelilingi podium supaya
        // dua orang yang masuk bersamaan tidak saling tumpang tindih.
        AFRAME.registerComponent('spawn-ring', {
            schema: { radius: { default: 3.4 } },
            init() {
                const sudut = Math.random() * Math.PI * 2;
                const x = Math.cos(sudut) * this.data.radius;
                const z = Math.sin(sudut) * this.data.radius;
                this.el.setAttribute('position', { x: x, y: 0, z: z });
                // Menghadap ke pusat ruang (maju A-Frame = -z lokal).
                this.el.setAttribute('rotation', { x: 0, y: Math.atan2(x, z) * 180 / Math.PI, z: 0 });
            }
        });

        // Papan nama selalu menghadap kamera pembaca.
        AFRAME.registerComponent('face-camera', {
            init() { this.pos = new THREE.Vector3(); },
            tick() {
                const cam = this.el.sceneEl.camera;
                if (!cam) return;
                cam.getWorldPosition(this.pos);
                this.el.object3D.lookAt(this.pos);
            }
        });

        // Menahan pemain tetap di dalam dinding lab (20 x 14 meter).
        AFRAME.registerComponent('bounded-movement', {
            tick() {
                const p = this.el.object3D.position;
                p.x = Math.max(-9.2, Math.min(9.2, p.x));
                p.z = Math.max(-6.3, Math.min(6.3, p.z));
            }
        });

        // Lantai lab: tekstur kanvas berisi kisi 1 meter + bingkai warna
        // aksen ruang, digambar saat halaman dimuat (tanpa file gambar).
        AFRAME.registerComponent('lab-floor', {
            schema: { accent: { type: 'string', default: '#2f5fe0' } },
            init() {
                const lebar = 1000, tinggi = 700, sel = 50; // 20 m x 14 m, 1 m = 50 px
                const kanvas = document.createElement('canvas');
                kanvas.width = lebar;
                kanvas.height = tinggi;
                const ctx = kanvas.getContext('2d');

                ctx.fillStyle = '#131c31';
                ctx.fillRect(0, 0, lebar, tinggi);

                ctx.strokeStyle = 'rgba(159, 179, 216, 0.10)';
                ctx.lineWidth = 1;
                for (let x = sel; x < lebar; x += sel) {
                    ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, tinggi); ctx.stroke();
                }
                for (let y = sel; y < tinggi; y += sel) {
                    ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(lebar, y); ctx.stroke();
                }

                // Garis utama tiap 5 m sedikit lebih tegas
                ctx.strokeStyle = 'rgba(159, 179, 216, 0.20)';
                for (let x = sel * 5; x < lebar; x += sel * 5) {
                    ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, tinggi); ctx.stroke();
                }
                for (let y = sel * 5; y < tinggi; y += sel * 5) {
                    ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(lebar, y); ctx.stroke();
                }

                // Bingkai tepi + lingkaran area podium memakai warna aksen ruang
                ctx.strokeStyle = this.data.accent;
                ctx.lineWidth = 10;
                ctx.globalAlpha = 0.85;
                ctx.strokeRect(12, 12, lebar - 24, tinggi - 24);
                ctx.globalAlpha = 0.4;
                ctx.lineWidth = 4;
                ctx.beginPath();
                ctx.arc(lebar / 2, tinggi / 2, 2.2 * sel, 0, Math.PI * 2);
                ctx.stroke();
                ctx.globalAlpha = 1;

                const tekstur = new THREE.CanvasTexture(kanvas);
                tekstur.anisotropy = 8;
                const pasang = () => {
                    const mesh = this.el.getObject3D('mesh');
                    if (!mesh) return;
                    mesh.material.map = tekstur;
                    mesh.material.color.set('#ffffff');
                    mesh.material.needsUpdate = true;
                };
                if (this.el.getObject3D('mesh')) pasang();
                else this.el.addEventListener('object3dset', pasang, { once: true });
            }
        });
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root { --accent: {{ $accent }}; }

        html, body { margin: 0; padding: 0; }

        .hud {
            position: fixed;
            z-index: 999999; /* di atas kanvas, tetap di bawah tombol VR bawaan A-Frame */
            font-family: 'Space Grotesk', system-ui, sans-serif;
            color: #eaf2ff;
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
        }
        .hud > * { pointer-events: auto; }

        .hud-top-left  { top: 14px; left: 14px; }
        .hud-top-right { top: 14px; right: 14px; align-items: flex-end; }
        .hud-bottom-left { bottom: 14px; left: 14px; }

        .hud-chip {
            background: rgba(10, 16, 32, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 14px;
            padding: 10px 14px;
            backdrop-filter: blur(10px) saturate(150%);
            -webkit-backdrop-filter: blur(10px) saturate(150%);
        }

        .hud-back {
            display: inline-block;
            color: #eaf2ff;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.86rem;
        }
        .hud-back:hover { color: var(--accent); }

        .hud-eyebrow {
            display: block;
            font-size: 0.64rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--accent);
            font-weight: 500;
        }
        .hud-room strong { font-size: 1rem; }

        .hud-status { display: flex; align-items: center; gap: 8px; font-size: 0.82rem; }
        #status-dot {
            width: 9px; height: 9px; border-radius: 50%;
            background: #f59e0b; display: inline-block;
        }
        #status-dot.ok   { background: #22c55e; }
        #status-dot.solo { background: #94a3b8; }

        .hud-count { font-size: 0.78rem; color: #b9c8e8; }
        .hud-count strong { color: #eaf2ff; }

        .hud-name { display: flex; align-items: center; gap: 8px; font-size: 0.78rem; }
        .hud-name input {
            width: 130px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 8px;
            color: #eaf2ff;
            font-family: inherit;
            font-size: 0.82rem;
            padding: 4px 8px;
            outline: none;
        }
        .hud-name input:focus { border-color: var(--accent); }

        #copy-link {
            background: var(--accent);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-family: inherit;
            font-weight: 700;
            font-size: 0.78rem;
            padding: 8px 12px;
            cursor: pointer;
        }
        #copy-link:hover { filter: brightness(1.12); }

        .hud-hint { font-size: 0.74rem; color: #b9c8e8; max-width: 340px; line-height: 1.5; }
        .hud-hint b { color: #eaf2ff; }

        @media (max-width: 640px) {
            .hud-hint { display: none; }
            .hud-name { display: none; }
        }
    </style>
</head>
<body>

    <a-scene
        networked-scene="room: lab-{{ $room->slug }}; app: lpske-vr; adapter: socketio; serverURL: {{ $serverUrl }}; audio: false; debug: false"
        renderer="antialias: true; colorManagement: true"
        background="color: #060a13"
        loading-screen="backgroundColor: #0b1224; dotsColor: {{ $accent }}">

        <a-assets>
            {{-- Template rig (badan/posisi pemain) — cukup entitas kosong --}}
            <template id="rig-template">
                <a-entity></a-entity>
            </template>

            {{-- Template avatar: kepala berwarna + "headset VR" + papan nama.
                 Inilah yang dilihat pemain lain di posisi kepala kita. --}}
            <template id="avatar-template">
                <a-entity class="avatar" player-info>
                    <a-sphere class="head" scale="0.18 0.2 0.18" color="#9fb3d8"></a-sphere>
                    <a-box class="visor" width="0.24" height="0.08" depth="0.09" position="0 0.02 -0.12"
                           color="#0d1322" material="metalness: 0.6; roughness: 0.25"></a-box>
                    <a-text class="nametag" value="" align="center" position="0 0.42 0"
                            scale="0.42 0.42 0.42" color="#eaf2ff" side="double" face-camera></a-text>
                </a-entity>
            </template>
        </a-assets>

        {{-- ===== Pencahayaan ===== --}}
        <a-entity light="type: ambient; color: #8ea6cc; intensity: 0.6"></a-entity>
        <a-entity light="type: directional; color: #ffffff; intensity: 0.5" position="4 8 6"></a-entity>
        <a-entity light="type: point; color: {{ $accent }}; intensity: 0.8; distance: 12" position="0 3.2 0"></a-entity>

        {{-- ===== Cangkang ruang: lantai, dinding, plafon ===== --}}
        <a-plane rotation="-90 0 0" width="20" height="14" color="#131c31"
                 material="roughness: 0.95" lab-floor="accent: {{ $accent }}"></a-plane>

        <a-box position="0 2 -7.15"  width="20.6" height="4" depth="0.3"  color="#10192e" material="roughness: 1"></a-box>
        <a-box position="0 2 7.15"   width="20.6" height="4" depth="0.3"  color="#10192e" material="roughness: 1"></a-box>
        <a-box position="-10.15 2 0" width="0.3"  height="4" depth="14.6" color="#10192e" material="roughness: 1"></a-box>
        <a-box position="10.15 2 0"  width="0.3"  height="4" depth="14.6" color="#10192e" material="roughness: 1"></a-box>

        {{-- Garis aksen menyala keliling dinding (atas & bawah) --}}
        <a-box position="0 3.1 -6.99"  width="20.6" height="0.05" depth="0.02" material="shader: flat; color: {{ $accent }}"></a-box>
        <a-box position="0 3.1 6.99"   width="20.6" height="0.05" depth="0.02" material="shader: flat; color: {{ $accent }}"></a-box>
        <a-box position="-9.99 3.1 0"  width="0.02" height="0.05" depth="14.6" material="shader: flat; color: {{ $accent }}"></a-box>
        <a-box position="9.99 3.1 0"   width="0.02" height="0.05" depth="14.6" material="shader: flat; color: {{ $accent }}"></a-box>
        <a-box position="0 0.35 -6.99" width="20.6" height="0.03" depth="0.02" material="shader: flat; color: {{ $accent }}; opacity: 0.5"></a-box>
        <a-box position="0 0.35 6.99"  width="20.6" height="0.03" depth="0.02" material="shader: flat; color: {{ $accent }}; opacity: 0.5"></a-box>
        <a-box position="-9.99 0.35 0" width="0.02" height="0.03" depth="14.6" material="shader: flat; color: {{ $accent }}; opacity: 0.5"></a-box>
        <a-box position="9.99 0.35 0"  width="0.02" height="0.03" depth="14.6" material="shader: flat; color: {{ $accent }}; opacity: 0.5"></a-box>

        <a-plane rotation="90 0 0" position="0 4 0" width="20" height="14" color="#0b1322"></a-plane>
        <a-plane rotation="90 0 0" position="-4.5 3.98 -3" width="2.6" height="1.3" material="shader: flat; color: #dfe9ff"></a-plane>
        <a-plane rotation="90 0 0" position="4.5 3.98 -3"  width="2.6" height="1.3" material="shader: flat; color: #dfe9ff"></a-plane>
        <a-plane rotation="90 0 0" position="-4.5 3.98 3"  width="2.6" height="1.3" material="shader: flat; color: #dfe9ff"></a-plane>
        <a-plane rotation="90 0 0" position="4.5 3.98 3"   width="2.6" height="1.3" material="shader: flat; color: #dfe9ff"></a-plane>

        {{-- ===== Podium tengah: manekin postur dengan penanda sendi ===== --}}
        <a-cylinder position="0 0.07 0" radius="1.5" height="0.14" color="#1b2745"
                    material="metalness: 0.3; roughness: 0.6"></a-cylinder>
        <a-ring rotation="-90 0 0" position="0 0.015 0" radius-inner="1.65" radius-outer="1.78"
                material="shader: flat; color: {{ $accent }}; opacity: 0.55"></a-ring>

        <a-entity position="0 0.14 0"
                  animation="property: rotation; to: 0 360 0; dur: 46000; easing: linear; loop: true">
            {{-- kaki, pinggul, badan, kepala --}}
            <a-cylinder position="-0.12 0.39 0" radius="0.07" height="0.78" color="#cfd9ee"></a-cylinder>
            <a-cylinder position="0.12 0.39 0"  radius="0.07" height="0.78" color="#cfd9ee"></a-cylinder>
            <a-box position="0 0.82 0" width="0.34" height="0.12" depth="0.2" color="#b9c8e8"></a-box>
            <a-box position="0 1.14 0" width="0.4" height="0.52" depth="0.22" color="#cfd9ee"></a-box>
            <a-cylinder position="0 1.44 0" radius="0.04" height="0.1" color="#b9c8e8"></a-cylinder>
            <a-sphere position="0 1.55 0" radius="0.13" color="#cfd9ee"></a-sphere>
            {{-- lengan kiri lurus ke bawah; lengan kanan menjangkau ke depan --}}
            <a-cylinder position="-0.26 1.08 0" radius="0.05" height="0.55" color="#cfd9ee"></a-cylinder>
            <a-cylinder position="0.26 1.43 -0.26" rotation="-70 0 0" radius="0.05" height="0.55" color="#cfd9ee"></a-cylinder>
            {{-- penanda penilaian postur ala RULA: hijau aman, kuning waspada, merah telaah --}}
            <a-sphere position="0 1.44 0.06"     radius="0.035" material="shader: flat; color: #f59e0b"></a-sphere>
            <a-sphere position="0.26 1.34 0"     radius="0.035" material="shader: flat; color: #ef4444"></a-sphere>
            <a-sphere position="0.26 1.5 -0.14"  radius="0.035" material="shader: flat; color: #f59e0b"></a-sphere>
            <a-sphere position="0.14 0.82 0.08"  radius="0.035" material="shader: flat; color: #22c55e"></a-sphere>
            <a-sphere position="-0.12 0.5 0.08"  radius="0.035" material="shader: flat; color: #22c55e"></a-sphere>
        </a-entity>

        {{-- Cincin holo mengambang di atas manekin --}}
        <a-torus rotation="90 0 0" position="0 2.05 0" radius="0.5" radius-tubular="0.015"
                 material="shader: flat; color: {{ $accent }}; opacity: 0.8"
                 animation="property: position; from: 0 1.98 0; to: 0 2.14 0; dir: alternate; dur: 2600; loop: true; easing: easeInOutSine"></a-torus>

        {{-- ===== Dua stasiun kerja analisis ===== --}}
        <a-entity position="-6.2 0 -3.5" rotation="0 35 0">
            <a-box position="0 0.92 0" width="2.4" height="0.08" depth="0.9" color="#223154"></a-box>
            <a-box position="-1.1 0.44 0" width="0.06" height="0.88" depth="0.8" color="#182643"></a-box>
            <a-box position="1.1 0.44 0"  width="0.06" height="0.88" depth="0.8" color="#182643"></a-box>
            <a-cylinder position="0 1.1 -0.25" radius="0.03" height="0.3" color="#182643"></a-cylinder>
            <a-box position="0 1.45 -0.28" width="0.95" height="0.55" depth="0.03" color="#060a13"></a-box>
            <a-plane position="0 1.45 -0.262" width="0.88" height="0.48" material="shader: flat; color: #0d1b33"></a-plane>
            <a-text value="RULA - Skor 5: telaah lanjut" position="0 1.45 -0.255" align="center" width="1.5" color="#9fd0ff"></a-text>
        </a-entity>

        <a-entity position="6.2 0 -3.5" rotation="0 -35 0">
            <a-box position="0 0.92 0" width="2.4" height="0.08" depth="0.9" color="#223154"></a-box>
            <a-box position="-1.1 0.44 0" width="0.06" height="0.88" depth="0.8" color="#182643"></a-box>
            <a-box position="1.1 0.44 0"  width="0.06" height="0.88" depth="0.8" color="#182643"></a-box>
            <a-cylinder position="0 1.1 -0.25" radius="0.03" height="0.3" color="#182643"></a-cylinder>
            <a-box position="0 1.45 -0.28" width="0.95" height="0.55" depth="0.03" color="#060a13"></a-box>
            <a-plane position="0 1.45 -0.262" width="0.88" height="0.48" material="shader: flat; color: #0d1b33"></a-plane>
            <a-text value="REBA - Skor 3: perlu perbaikan" position="0 1.45 -0.255" align="center" width="1.5" color="#9fd0ff"></a-text>
        </a-entity>

        {{-- ===== Rak alat di dekat dinding kanan ===== --}}
        <a-entity position="9.6 0 2.5" rotation="0 -90 0">
            <a-box position="0 1 0"   width="1.8" height="0.05" depth="0.35" color="#223154"></a-box>
            <a-box position="0 1.5 0" width="1.8" height="0.05" depth="0.35" color="#223154"></a-box>
            <a-box position="-0.85 0.75 0" width="0.05" height="1.55" depth="0.35" color="#182643"></a-box>
            <a-box position="0.85 0.75 0"  width="0.05" height="1.55" depth="0.35" color="#182643"></a-box>
            <a-box position="-0.4 1.13 0" width="0.25" height="0.2" depth="0.2" color="{{ $accent }}"></a-box>
            <a-box position="0.2 1.11 0"  width="0.3"  height="0.16" depth="0.18" color="#f59e0b"></a-box>
            <a-box position="0.55 1.62 0" width="0.2"  height="0.18" depth="0.2" color="#22c55e"></a-box>
            <a-cylinder position="-0.45 1.66 0" radius="0.07" height="0.26" color="#b9c8e8"></a-cylinder>
        </a-entity>

        {{-- ===== Papan dinding (isi teks diisi lewat JS di bawah) ===== --}}
        {{-- Papan judul, dinding belakang --}}
        <a-plane position="0 2.2 -6.84" width="7.1" height="2.5" material="shader: flat; color: {{ $accent }}; opacity: 0.28"></a-plane>
        <a-plane position="0 2.2 -6.83" width="6.9" height="2.3" material="shader: flat; color: #0e1730; opacity: 0.94">
            <a-text value="VR ERGONOMY LAB - LPSKE" position="0 0.82 0.01" align="center" width="3.4" color="{{ $accent }}"></a-text>
            <a-text id="board-judul" value="" position="0 0.28 0.01" align="center" width="8.5" color="#eaf2ff"></a-text>
            <a-text id="board-tema" value="" position="0 -0.28 0.01" align="center" width="4.6" color="#b9c8e8"></a-text>
            <a-text id="board-online" value="" position="0 -0.72 0.01" align="center" width="3.6" color="#8fa3c8"></a-text>
        </a-plane>

        {{-- Papan capaian, dinding kiri --}}
        <a-plane position="-9.83 2.1 -0.5" rotation="0 90 0" width="5.6" height="2.7" material="shader: flat; color: #0e1730; opacity: 0.94">
            <a-text value="CAPAIAN PEMBELAJARAN" position="-2.5 1.05 0.01" align="left" width="4.2" color="{{ $accent }}"></a-text>
            <a-text id="board-capaian" value="" position="-2.5 0.15 0.01" align="left" width="4.6" color="#dbe6ff"></a-text>
        </a-plane>

        {{-- Papan modul, dinding kanan --}}
        <a-plane position="9.83 2.1 -0.5" rotation="0 -90 0" width="5.6" height="2.7" material="shader: flat; color: #0e1730; opacity: 0.94">
            <a-text value="MODUL DI RUANG INI" position="-2.5 1.05 0.01" align="left" width="4.2" color="{{ $accent }}"></a-text>
            <a-text id="board-modul" value="" position="-2.5 0.15 0.01" align="left" width="4.6" color="#dbe6ff"></a-text>
        </a-plane>

        {{-- Tulisan di dinding depan (terlihat saat berbalik) --}}
        <a-text value="LPSKE - Laboratorium Perancangan Sistem Kerja dan Ergonomi"
                position="0 2.6 6.82" rotation="0 180 0" align="center" width="9" color="#93a9d8"></a-text>

        {{-- ===== Pemain lokal ===== --}}
        <a-entity id="rig"
                  networked="template: #rig-template"
                  movement-controls="speed: 0.3"
                  bounded-movement
                  spawn-ring="radius: 3.4">
            <a-entity id="player"
                      camera
                      position="0 1.6 0"
                      look-controls="pointerLockEnabled: false"
                      networked="template: #avatar-template"
                      player-info
                      visible="false"></a-entity>
        </a-entity>
    </a-scene>

    {{-- ===================== HUD ===================== --}}
    <div class="hud hud-top-left">
        <div class="hud-chip">
            <a class="hud-back" href="{{ route('vr-ergonomy.room', $room) }}">&larr; Keluar dari VR</a>
        </div>
        <div class="hud-chip hud-room">
            <span class="hud-eyebrow">VR Ergonomy Lab</span>
            <strong>{{ $room->nama }}</strong>
        </div>
    </div>

    <div class="hud hud-top-right">
        <div class="hud-chip hud-status">
            <span id="status-dot"></span>
            <span id="status-text">Menghubungkan ke server&hellip;</span>
        </div>
        <div class="hud-chip hud-count"><strong id="online-count">1</strong> orang di ruang ini</div>
        <div class="hud-chip hud-name">
            <label for="name-input">Nama</label>
            <input id="name-input" maxlength="18" autocomplete="off" spellcheck="false">
        </div>
        <button id="copy-link" type="button">Salin tautan &mdash; ajak teman masuk</button>
    </div>

    <div class="hud hud-bottom-left">
        <div class="hud-chip hud-hint">
            <b>WASD / panah</b> berjalan &middot; <b>seret mouse</b> melihat sekeliling &middot;
            di HP: <b>sentuh &amp; seret</b> &middot; ikon kacamata kanan bawah untuk <b>mode headset VR</b>.
        </div>
    </div>

    <script>
        (function () {
            'use strict';

            /* ===== Isi papan dinding dari database ===== */
            var ROOM = {
                nama: @json($room->nama),
                tema: @json($room->tema ?? ''),
                capaian: @json($capaianLines),
                modul: @json($modulLines)
            };

            document.getElementById('board-judul').setAttribute('value', ROOM.nama.toUpperCase());
            document.getElementById('board-tema').setAttribute('value', ROOM.tema);
            document.getElementById('board-capaian').setAttribute('value', ROOM.capaian);
            document.getElementById('board-modul').setAttribute('value', ROOM.modul);

            /* ===== Status koneksi + jumlah pemain ===== */
            var dot = document.getElementById('status-dot');
            var statusText = document.getElementById('status-text');
            var countEl = document.getElementById('online-count');
            var boardOnline = document.getElementById('board-online');
            var terhubung = false;
            var pemainLain = new Set();

            function tampilkanJumlah() {
                var total = pemainLain.size + 1;
                countEl.textContent = total;
                boardOnline.setAttribute('value', total + ' orang sedang berada di ruang ini');
            }

            document.body.addEventListener('connected', function () {
                terhubung = true;
                dot.className = 'ok';
                statusText.textContent = 'Multiplayer aktif';
                tampilkanJumlah();
            });

            document.body.addEventListener('clientConnected', function (e) {
                pemainLain.add(e.detail.clientId);
                tampilkanJumlah();
            });

            document.body.addEventListener('clientDisconnected', function (e) {
                pemainLain.delete(e.detail.clientId);
                tampilkanJumlah();
            });

            // Server mati bukan berarti halaman mati: scene tetap bisa
            // dijelajahi sendirian.
            setTimeout(function () {
                if (!terhubung) {
                    dot.className = 'solo';
                    statusText.textContent = 'Mode solo (server multiplayer tidak aktif)';
                }
            }, 10000);

            tampilkanJumlah();

            /* ===== Ganti nama ===== */
            document.getElementById('name-input').addEventListener('input', function () {
                var nama = this.value.trim();
                if (!nama) return;
                sessionStorage.setItem('lpske-vr-nama', nama);
                var player = document.getElementById('player');
                if (player) player.setAttribute('player-info', 'name', nama);
            });

            /* ===== Salin tautan ajakan ===== */
            var tombolSalin = document.getElementById('copy-link');
            tombolSalin.addEventListener('click', function () {
                var url = window.location.href;
                var selesai = function () {
                    tombolSalin.textContent = 'Tautan disalin!';
                    setTimeout(function () {
                        tombolSalin.innerHTML = 'Salin tautan &mdash; ajak teman masuk';
                    }, 2200);
                };
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url).then(selesai);
                } else {
                    window.prompt('Salin tautan ini:', url);
                }
            });
        })();
    </script>
</body>
</html>
