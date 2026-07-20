# Panduan Setup Database (XAMPP di Windows)

Dokumen ini menjelaskan cara menyiapkan database **`lpske`** menggunakan **XAMPP for Windows**
(umumnya terpasang di `C:\xampp`). File SQL siap impor tersedia di **`database\sql\lpske.sql`**.

Semua perintah dijalankan lewat **Command Prompt (CMD)** atau **PowerShell**. Kalau lebih suka
tampilan grafis, gunakan cara **phpMyAdmin** di bawah.

---

## 1. Jalankan MySQL lewat XAMPP Control Panel

1. Buka **XAMPP Control Panel** (`C:\xampp\xampp-control.exe`) — bisa juga dari Start Menu.
2. Klik tombol **Start** pada baris **MySQL**.
   - Kalau mau memakai phpMyAdmin, klik **Start** juga pada baris **Apache**.
3. Kalau tombol berubah hijau dan muncul nomor **Port(s)** (biasanya `3306`), berarti MySQL sudah jalan.

Cek port MySQL yang aktif lewat CMD:

```bat
netstat -ano | findstr 3306
```

> **Penting soal port:** nilai `DB_PORT` di file `.env` **harus sama** dengan port MySQL yang
> aktif. XAMPP standar memakai **3306**, jadi `.env` harus `DB_PORT=3306`.

---

## 2. Impor database `lpske`

File `database\sql\lpske.sql` sudah berisi perintah `CREATE DATABASE` + seluruh tabel + data
(termasuk akun login). Pilih salah satu cara di bawah.

### Cara A — lewat CMD (paling cepat)

Buka CMD, masuk ke folder project (yang berisi file `artisan`), lalu jalankan:

```bat
C:\xampp\mysql\bin\mysql.exe -u root < database\sql\lpske.sql
```

Kalau user root MySQL kamu memakai password, tambahkan `-p`:

```bat
C:\xampp\mysql\bin\mysql.exe -u root -p < database\sql\lpske.sql
```

> Tip: kalau tidak mau mengetik path panjang `C:\xampp\mysql\bin\mysql.exe` berulang kali,
> kamu bisa menambahkan `C:\xampp\mysql\bin` ke **Environment Variables → Path**, sehingga
> cukup mengetik `mysql`.

### Cara B — lewat phpMyAdmin (grafis, tanpa ketik perintah)

1. Pastikan **Apache** dan **MySQL** sudah **Start** di XAMPP Control Panel.
2. Buka browser ke **http://localhost/phpmyadmin**.
3. Klik tab **Databases**, buat database baru bernama `lpske`
   (collation `utf8mb4_general_ci`), lalu klik **Create**.
   - *(Boleh dilewati — file SQL sudah memuat perintah `CREATE DATABASE` sendiri.)*
4. Pilih database `lpske` di panel kiri → klik tab **Import**.
5. Klik **Choose File**, pilih file `database\sql\lpske.sql`, lalu klik **Import / Go** di bawah.

---

## 3. Verifikasi

Lewat CMD:

```bat
:: Lihat daftar database
C:\xampp\mysql\bin\mysql.exe -u root -e "SHOW DATABASES;"

:: Lihat tabel di dalam lpske
C:\xampp\mysql\bin\mysql.exe -u root -e "USE lpske; SHOW TABLES;"

:: Cek akun yang tersedia
C:\xampp\mysql\bin\mysql.exe -u root -e "SELECT id, name, email, role FROM lpske.users;"
```

Atau lewat phpMyAdmin: pilih database `lpske` di panel kiri dan lihat daftar tabelnya.

Kalau koneksi dari Laravel berhasil, perintah ini menampilkan status migration:

```bat
php artisan migrate:status
```

---

## 4. (Opsional) Membuat database dari nol tanpa file SQL

Kalau ingin membangun struktur dari migration Laravel, bukan dari file SQL:

```bat
:: Buat database kosong dulu
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS lpske CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

:: Jalankan migration + seeder (membuat akun default)
php artisan migrate --seed
```

> Cara ini membuat akun default dari seeder: `admin@lpske.com / admin123`,
> `asisten@lpske.com / asisten123`, `anggota@lpske.com / anggota123`.

---

## 5. Membuat ulang file SQL (backup / ekspor)

Kalau kamu mengubah data dan ingin memperbarui file `database\sql\lpske.sql`:

```bat
C:\xampp\mysql\bin\mysqldump.exe -u root --databases lpske --add-drop-database --default-character-set=utf8mb4 > database\sql\lpske.sql
```

Atau lewat phpMyAdmin: pilih database `lpske` → tab **Export** → **Go**.

---

## Troubleshooting

| Masalah | Penyebab & Solusi |
|---|---|
| `SQLSTATE[HY000] [2002]` / `Connection refused` | MySQL belum jalan → Start MySQL di XAMPP Control Panel |
| MySQL tidak mau Start / langsung mati | Port 3306 dipakai aplikasi lain (mis. MySQL Workbench, layanan MySQL Windows). Matikan aplikasi itu, atau ganti port MySQL di XAMPP lalu samakan `DB_PORT` di `.env` |
| `Access denied for user 'root'` | Password root salah. XAMPP default root **tanpa password** (`DB_PASSWORD=` kosong) |
| `Unknown database 'lpske'` | Database belum diimpor → ulangi langkah 2 |
| `'mysql' is not recognized` | Path salah. Pakai path lengkap `C:\xampp\mysql\bin\mysql.exe`, atau tambahkan folder itu ke PATH |
| Perubahan `.env` tidak terbaca | Jalankan `php artisan config:clear` |
