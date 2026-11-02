# UjiNalar — Platform Kuis Interaktif Berbasis Web

UjiNalar adalah aplikasi kuis edukatif untuk mengasah pengetahuan melalui pertanyaan pilihan ganda. Aplikasi ini dikembangkan sebagai proyek portofolio yang memperlihatkan penerapan MVC Laravel, antarmuka berbasis Blade, dan pemrosesan formulir yang aman tanpa memerlukan database.

Kuis interaktif membantu pengguna mengenali pemahaman mereka sekaligus menemukan pengetahuan baru. Setiap jawaban dilengkapi pembahasan singkat agar proses belajar berlanjut setelah nilai ditampilkan. Seluruh antarmuka menggunakan bahasa Indonesia dengan desain minimalis, tipografi Inter, dan tata letak yang menyesuaikan ukuran layar.

## Fitur Utama

- Tiga kategori: Pengetahuan Umum, Teknologi, dan Sains.
- Delapan soal per kategori, masing-masing dengan empat pilihan jawaban.
- Indikator jumlah soal yang sudah dijawab, tanpa batas waktu.
- Validasi seluruh jawaban sebelum kuis dinilai.
- Penilaian otomatis berupa jumlah benar, jumlah salah, dan persentase.
- Pembahasan yang menampilkan jawaban pengguna, kunci, serta penjelasan.
- Tombol untuk mengulangi kuis atau memilih kategori lain.

## Teknologi

Laravel 13 dan PHP digunakan untuk routing, validasi, serta penghitungan skor di controller. Blade menjadi mesin templat utama dengan HTML5 dan CSS3. JavaScript murni hanya memperbarui indikator jawaban; kuis tetap berfungsi ketika JavaScript dinonaktifkan. Vite membangun aset frontend. Font Inter disimpan lokal beserta lisensinya sehingga aplikasi tidak bergantung pada layanan font eksternal saat dijalankan.

## Alur Penggunaan

1. Pilih kategori dari beranda.
2. Baca delapan pertanyaan dan pilih satu jawaban pada setiap soal.
3. Tekan **Selesaikan Kuis** untuk mengirim jawaban.
4. Lihat skor dan pelajari pembahasan setiap pertanyaan.
5. Tekan **Ulangi Kuis** untuk memulai dengan pilihan kosong, atau kembali ke beranda.

## Cara Menjalankan

Siapkan PHP 8.3 atau lebih baru, Composer 2, dan Node.js 22.12+ atau 24+. PHP bawaan MAMP yang memenuhi persyaratan juga dapat digunakan. Pastikan ekstensi standar Laravel tersedia.

```bash
composer install
cp .env.example .env
php artisan key:generate
npm ci
npm run build
php artisan serve
```

Buka alamat yang ditampilkan Artisan, biasanya `http://127.0.0.1:8000`. Konfigurasi bawaan menggunakan sesi dan cache berbasis berkas serta antrean sinkron; migrasi database tidak diperlukan. Untuk MAMP, arahkan akar dokumen ke direktori `public`, bukan direktori utama proyek. Simpan `.env` secara lokal dan jangan masukkan kredensial ke Git.

Jalankan pengujian aplikasi dengan:

```bash
php artisan test
```

Soal dipisahkan per kategori dalam `config/questions`, lalu dirangkai melalui `config/quiz.php`. Untuk menambah soal, gunakan ID unik, empat opsi, kunci yang sesuai, dan penjelasan faktual. Kunci serta pembahasan tidak dikirim ke halaman pengerjaan. Pengiriman menggunakan POST, perlindungan CSRF, dan validasi server; skor dari browser tidak dipercaya.

## Batasan Aplikasi

Versi ini belum menggunakan database, akun pengguna, maupun penyimpanan riwayat nilai. Kuis memakai kumpulan soal bawaan dengan urutan tetap. Hasil ditampilkan langsung setelah pengiriman, tanpa disimpan sebagai riwayat. Tidak tersedia timer, pengacakan soal, atau panel administrasi.
