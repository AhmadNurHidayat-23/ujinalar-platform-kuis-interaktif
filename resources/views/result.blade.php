@extends('layouts.app')
@section('title', 'Hasil Kuis')

@section('content')
    <div class="reading-column">
        <a class="back-link" href="{{ route('home') }}"><span aria-hidden="true">←</span> Beranda</a>
        <header class="page-heading result-heading">
            <p class="eyebrow">{{ $category['name'] }} / Selesai</p>
            <h1>Hasil Kuis</h1>
            <p>{{ $correct === $total ? 'Luar biasa, semua jawabanmu tepat. Terus jaga rasa ingin tahumu.' : 'Satu langkah lagi dalam belajar. Mari lihat apa yang sudah kamu pahami.' }}</p>
        </header>
        <section class="score-panel" aria-label="Ringkasan hasil kuis">
            <div class="score-main"><p class="eyebrow">Skor akhir</p><p class="score-value">{{ str_replace('.', ',', (string) $score) }}<span>/100</span></p></div>
            <dl class="score-details"><div><dt>Jawaban benar</dt><dd>{{ $correct }} <span>dari {{ $total }}</span></dd></div><div><dt>Jawaban salah</dt><dd>{{ $wrong }}</dd></div><div><dt>Persentase nilai</dt><dd>{{ str_replace('.', ',', (string) $score) }}%</dd></div></dl>
        </section>
        <div class="result-actions"><a class="button" href="{{ route('quiz.show', $category['slug']) }}">Ulangi Kuis <span aria-hidden="true">↗</span></a><a class="button button-secondary" href="{{ route('home') }}">Kembali ke Beranda</a></div>
        <section class="reviews" aria-labelledby="reviews-title">
            <div class="section-heading"><h2 id="reviews-title">Di balik setiap jawaban.</h2><span>Pembahasan {{ $total }} soal</span></div>
            @foreach($reviews as $review)
                <article class="review">
                    <div class="review-top"><p class="question-number">SOAL {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</p><span class="answer-badge">{{ $review['correct'] ? '✓ Benar' : '× Salah' }}</span></div>
                    <h3>{{ $review['text'] }}</h3>
                    <dl class="review-answers"><div><dt>Jawabanmu</dt><dd>{{ strtoupper($review['selected']) }}. {{ $review['options'][$review['selected']] }}</dd></div><div><dt>Jawaban benar</dt><dd>{{ strtoupper($review['answer']) }}. {{ $review['options'][$review['answer']] }}</dd></div></dl>
                    <p class="explanation">{{ $review['explanation'] }}</p>
                </article>
            @endforeach
        </section>
    </div>
@endsection
