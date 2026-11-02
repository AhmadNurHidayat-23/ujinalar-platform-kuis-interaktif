# UjiNalar

Aplikasi kuis edukatif Laravel 13, Blade, CSS murni, dan JavaScript minimal.

## Lingkup

- Kerjakan hanya repository UjiNalar.
- Seluruh antarmuka dan dokumentasi harus berbahasa Indonesia.
- Jangan menambahkan database, autentikasi, panel administrasi, atau framework frontend.
- Jangan menambahkan dependency tanpa kebutuhan nyata.

## Struktur

- `config/questions/`: kumpulan soal per kategori.
- `config/quiz.php`: metadata dan pemetaan kategori.
- `app/Support/QuizBank.php`: pengambilan data serta penyaringan kunci sebelum rendering.
- `app/Http/Controllers/QuizController.php`: validasi dan perhitungan skor.
- `resources/views/`: templat Blade dengan output escaping.
- `resources/css/` dan `resources/js/`: aset terpisah yang dibangun Vite.

## Aturan

- Maksimal 300 baris kode per file sumber; lockfile dan file hasil build tidak termasuk.
- Tidak ada CSS atau JavaScript inline dalam Blade.
- Penilaian selalu dilakukan di server dan menggunakan kunci bawaan.
- Jangan mengirim kunci maupun pembahasan sebelum jawaban tervalidasi.
- Gunakan POST, CSRF, serta validasi struktur, ID soal, dan pilihan jawaban.
- Sesi dan cache berbasis berkas; migrasi tidak diperlukan.
- Jangan commit `.env`, `vendor`, `node_modules`, hasil build, atau data sesi.

## Pemeriksaan

```bash
php artisan test
npm run build
```

Periksa alur beranda, kuis, hasil, pembahasan, dan ulangi kuis pada layar desktop serta ponsel.
