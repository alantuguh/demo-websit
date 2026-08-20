# vr-server — Server Multiplayer VR Ergonomy Lab

Server Node kecil yang menyinkronkan posisi/rotasi avatar antar pengunjung
di halaman `/vr-ergonomy/{ruang}/vr`. Scene-nya dibangun dengan
[A-Frame](https://aframe.io) 1.7 + [Networked-A-Frame](https://github.com/networked-aframe/networked-aframe)
0.14 (adapter `socketio`); server ini implementasi protokol relay-nya —
tidak menyimpan apa pun, murni penyampai pesan antar browser.

## Menjalankan (pengembangan lokal)

```bash
cd vr-server
npm install        # sekali saja
npm start          # siap di http://localhost:8080
```

atau dari root proyek: `npm run vr-server`.

Lalu jalankan Laravel seperti biasa (`php artisan serve`), buka satu ruang
di `/vr-ergonomy`, klik **Masuk Lab VR**. Buka URL yang sama di tab/perangkat
kedua — avatar saling terlihat. Buka `http://localhost:8080/` untuk melihat
daftar ruang yang sedang terisi.

## Konfigurasi

| Apa | Di mana | Bawaan |
| --- | --- | --- |
| Port server | env `PORT` saat menjalankan server | `8080` |
| Alamat yang dipakai browser | `VR_MULTIPLAYER_URL` di `.env` Laravel | `ws://localhost:8080` |

`VR_MULTIPLAYER_URL` dibaca browser pengunjung, bukan server Laravel — di
jaringan lab isi dengan IP mesin yang menjalankan server ini
(mis. `ws://192.168.1.10:8080`) supaya perangkat lain bisa ikut.

## Kalau server tidak jalan

Halaman VR tetap bisa dibuka dan dijelajahi sendirian; HUD menampilkan
"mode solo" dan tidak ada avatar lain. Tidak ada error yang menghentikan
scene.

## Catatan produksi

- Server produksi situs ini tidak punya Node.js, jadi vr-server perlu host
  terpisah (VPS kecil / Railway / Fly.io — RAM kebutuhan kecil, state hanya
  di memori).
- Halaman HTTPS hanya boleh membuka koneksi `wss://` — pasang reverse proxy
  TLS (nginx/Caddy) di depan port 8080, lalu isi
  `VR_MULTIPLAYER_URL=wss://vr.domain-anda.ac.id`.
- Masuk mode VR (tombol headset) juga mensyaratkan halaman diakses lewat
  HTTPS atau `localhost` — ini syarat WebXR di browser, bukan syarat server.
