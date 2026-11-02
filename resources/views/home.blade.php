@extends('layouts.app')

@section('content')
    <section class="hero" aria-labelledby="hero-title">
        <p class="eyebrow"><span class="square" aria-hidden="true"></span> Ruang kecil untuk rasa ingin tahu</p>
        <h1 id="hero-title">Uji<br>Pengetahuanmu.</h1>
        <div class="hero-bottom">
            <p class="intro">Asah kemampuan dan perluas wawasan melalui kuis interaktif yang sederhana dan menyenangkan.</p>
            <a class="text-link" href="#kategori">Temukan kuismu <span aria-hidden="true">↘</span></a>
        </div>
    </section>

    <section id="kategori" class="categories" aria-labelledby="category-title">
        <div class="section-heading">
            <h2 id="category-title">Pilih rasa ingin tahumu.</h2>
            <p>03 kategori / 08 soal per kuis</p>
        </div>
        <div class="category-grid">
            @foreach($categories as $category)
                <article class="category-card">
                    <div class="card-top"><span class="category-number">0{{ $loop->iteration }}</span><span>{{ $category['label'] }}</span></div>
                    <div class="category-symbol" aria-hidden="true">@include('partials.category-symbol', ['slug' => $category['slug']])</div>
                    <h3>{{ $category['name'] }}</h3>
                    <p class="card-description">{{ $category['description'] }}</p>
                    <p class="card-meta">{{ $category['count'] }} soal <span aria-hidden="true">·</span> Tanpa batas waktu</p>
                    <a class="button" href="{{ route('quiz.show', $category['slug']) }}" aria-label="Mulai Kuis {{ $category['name'] }}">Mulai Kuis <span aria-hidden="true">↗</span></a>
                </article>
            @endforeach
        </div>
    </section>

    <section id="tentang" class="about" aria-labelledby="about-title">
        <p class="eyebrow">Tentang UjiNalar</p>
        <div>
            <h2 id="about-title">Bukan sekadar benar atau salah.<br>Selalu ada hal baru untuk dipelajari.</h2>
            <p>UjiNalar memberi ruang untuk mengasah pengetahuan tanpa terburu-buru. Pilih kategori, jawab delapan soal, lalu pahami setiap jawaban lewat pembahasannya. Tanpa akun, langsung mulai.</p>
            <ol class="steps"><li>Pilih kategori</li><li>Uji pengetahuan</li><li>Pelajari pembahasan</li></ol>
        </div>
    </section>
@endsection
