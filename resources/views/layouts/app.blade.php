<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Asah pengetahuan melalui kuis Pengetahuan Umum, Teknologi, dan Sains. Delapan soal, skor otomatis, dan pembahasan yang mudah dipahami.">
    <meta name="theme-color" content="#171717">
    <title>@yield('title', 'Uji Pengetahuanmu') — UjiNalar</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#konten">Langsung ke konten</a>
    <header class="site-header wrap">
        <a class="brand" href="{{ route('home') }}" aria-label="UjiNalar, beranda">ujinalar.</a>
        <nav aria-label="Navigasi utama">
            <a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Beranda</a>
            <a href="{{ route('home') }}#tentang">Tentang</a>
        </nav>
    </header>
    <main id="konten" class="wrap">@yield('content')</main>
    <footer class="site-footer wrap">
        <a class="brand brand-small" href="{{ route('home') }}">ujinalar.</a>
        <p>Rasa ingin tahu adalah awal pengetahuan.</p>
        <span>Belajar, satu soal setiap kali.</span>
    </footer>
</body>
</html>
