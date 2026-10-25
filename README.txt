BURGER NUSANTARA - Panel Admin & Website Dinamis
Tugas 3 Praktikum Desain & Pemrograman Web

Petunjuk Menjalankan Aplikasi:
1. Pindahkan atau salin folder proyek ini ke dalam folder C:\laragon\www\
2. Buka Laragon, klik "Start All" untuk menyalakan Apache dan MySQL.
3. Import file database/db_burger_nusantara.sql menggunakan:
   - HeidiSQL: Menu File > Run SQL file... pilih database/db_burger_nusantara.sql, atau
   - phpMyAdmin: Buka http://localhost/phpmyadmin, buat database db_burger_nusantara atau pilih tab Import, lalu unggah database/db_burger_nusantara.sql.
4. Buka website di browser melalui:
   - Halaman Publik : http://localhost/burger-nusantara/ (atau sesuaikan nama folder)
   - Panel Admin    : http://localhost/burger-nusantara/admin/login.php

Akun Login Admin:
- Username : admin
- Password : admin123

Struktur Direktori:
burger-nusantara/
|-- .htaccess              (konfigurasi server Apache dan rewrite)
|-- README.txt             (panduan instalasi dan penggunaan)
|-- index.php              (halaman utama publik dinamis)
|-- tentang.html           (halaman profil lengkap statis)
|-- koneksi.php            (koneksi database mysqli)
|-- style.css              (stylesheet utama publik dan admin)
|-- fonts/                 (font lokal Outfit dan Plus Jakarta Sans)
|-- images/                (aset gambar burger, pendamping, dan logo)
|-- includes/              (header dan footer halaman publik)
|-- admin/                 (panel kendali pengelola aplikasi)
|   |-- login.php          (form login admin)
|   |-- logout.php         (logout dan pembersihan session)
|   |-- cek_login.php      (proteksi session guard admin)
|   |-- index.php          (dashboard ringkasan data)
|   |-- includes/          (header navbar dan footer admin)
|   |-- menu/              (CRUD data menu: index, tambah, edit, hapus)
|   |-- paket/             (CRUD data paket combo: index, tambah, edit, hapus)
|   \-- cabang/            (CRUD data outlet cabang: index, tambah, edit, hapus)
|-- database/
|   \-- db_burger_nusantara.sql  (dump database lengkap 5 tabel)
\-- Screenshot/            (bukti tangkapan layar 1440x900)
    |-- umum/              (login, dashboard, beranda, tentang)
    |-- menu/              (7 gambar alur CRUD: tampil, tambah, ubah, hapus)
    |-- paket/             (7 gambar alur CRUD: tampil, tambah, ubah, hapus)
    \-- cabang/            (7 gambar alur CRUD: tampil, tambah, ubah, hapus)

Penjelasan Folder Screenshot (Ketentuan D3):
- umum/: 4 file gambaran umum (01-login, 02-dashboard, 03-beranda-publik, 04-tentang-publik).
- menu/, paket/, cabang/: masing-masing berisi 7 gambar berpasangan:
  * 01-tampil-awal.png      : Tabel daftar data awal (sebelum ditambah).
  * 02-tambah-form.png      : Formulir penambahan data terisi data uji.
  * 03-tambah-sesudah.png   : Tabel setelah simpan (baris baru + alert notifikasi sukses).
  * 04-ubah-sebelum.png     : Formulir ubah terisi data lama.
  * 05-ubah-sesudah.png     : Tabel setelah diubah (nilai baru + alert notifikasi sukses).
  * 06-hapus-sebelum.png    : Halaman konfirmasi hapus permanen tanpa JavaScript.
  * 07-hapus-sesudah.png    : Tabel setelah data dihapus (baris hilang + alert sukses).

Identitas Pengembang:
Dibuat oleh: Muhammad Naufal Alifaturafif
NIM: 240705136
Praktikum Desain dan Pemrograman Web
