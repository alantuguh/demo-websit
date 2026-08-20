<?php

/*
 * Konfigurasi VR Ergonomy Lab.
 *
 * Scene multiplayer (resources/views/vr-ergonomy/vr.blade.php) memakai
 * Networked-A-Frame dengan adapter socket.io. Sinkronisasi posisi antar
 * pemain ditangani server Node kecil di folder vr-server/ — jalankan dengan
 * `npm run vr-server` dari root proyek.
 *
 * Kalau server ini tidak jalan, halaman VR tetap bisa dibuka dan dijelajahi
 * sendirian (mode solo); hanya avatarnya yang tidak tersinkron.
 */
return [

    // Alamat server multiplayer dilihat DARI BROWSER pengunjung, bukan dari
    // server Laravel. Di produksi arahkan ke host ber-TLS (wss://...) yang
    // mem-proxy vr-server, mis. wss://vr.contoh.ac.id
    'server_url' => env('VR_MULTIPLAYER_URL', 'ws://localhost:8080'),

];
