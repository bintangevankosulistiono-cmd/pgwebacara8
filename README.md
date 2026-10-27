# Latihan 8 â€” PHP View dan Input Database

Aplikasi ini menampilkan data kecamatan dari MySQL dan menyediakan formulir untuk menambahkan data, termasuk longitude dan latitude.

## Menjalankan dengan XAMPP

1. Salin folder `Script` ke `C:\xampp\htdocs\Script` (atau letakkan folder ini di document root Apache).
2. Jalankan Apache dan MySQL dari XAMPP.
3. Buka phpMyAdmin, pilih tab **Import**, lalu impor file `database.sql`. File tersebut membuat database `latihan`, tabel `penduduk`, dan lima data contoh dari panduan praktikum.
4. Jika MySQL lokal memakai konfigurasi praktikum, `db.php` sudah memakai `localhost`, user `root`, password `password`, dan database `latihan`. Sesuaikan default tersebut atau set environment variables `DB_HOST`, `DB_USER`, `DB_PASSWORD`, dan `DB_NAME` bila konfigurasi berbeda.
5. Buka `http://localhost/Script/` di browser. Pilih **Tambah data** untuk memasukkan data baru.

## Validasi

Form memeriksa nama kecamatan, longitude (-180 sampai 180), latitude (-90 sampai 90), luas lebih besar dari nol, serta jumlah penduduk berupa bilangan bulat minimal nol. Pemeriksaan yang sama dilakukan kembali di server sebelum data disimpan.

