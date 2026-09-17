# Absensi Eni Muara Bakau

Aplikasi CodeIgniter 3 untuk pencatatan aktivitas dan perizinan pegawai dengan tiga role: pegawai, atasan, dan monitoring.

## Menjalankan aplikasi

1. Buat database lewat phpMyAdmin dengan mengimpor `database/absensi_eni_muarabakau.sql`.
2. Salin `application/config/database.example.php` menjadi `application/config/database.php`, lalu sesuaikan koneksi MySQL lokal. File konfigurasi lokal tidak masuk Git.
3. Letakkan folder ini di document root Apache dan buka `http://localhost/Absensi_EniMuaraBakau/`.

## Akun demo

Semua akun menggunakan password `password123`.

- `demo_pegawai`
- `demo_atasan`
- `demo_monitoring`

Laporan Monitoring hanya memasukkan aktivitas dengan status **Approved** dan menghasilkan PDF A4 melalui TCPDF. Implementasi saat ini menggunakan TCPDF bawaan phpMyAdmin pada XAMPP macOS di `/Applications/XAMPP/xamppfiles/phpmyadmin/vendor/tecnickcom/tcpdf/tcpdf.php`. Sesuaikan lokasi di `application/libraries/Pdf.php` jika instalasi berbeda. Dependensi Dompdf pada Composer merupakan dependensi lama, bukan renderer timesheet aktif.

Pastikan folder `assets/uploads`, cache/log, dan lokasi sesi yang ditentukan di `application/config/config.php` dapat ditulis oleh Apache. Jangan memberi akses tulis ke seluruh source aplikasi.

Database SQL hanya berisi data demo. Jangan impor ulang ke database berisi data kerja tanpa backup. Ganti password demo dan placeholder encryption key sebelum penggunaan produksi.

Upload pengguna, log, sesi, vendor, serta hasil pengujian lokal tidak disertakan dalam repository.
