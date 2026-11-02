@extends('layouts.app')
@section('title', 'Halaman ini memerlukan pengiriman kuis')
@section('content')
    <section class="error-page">
        <span class="eyebrow">405 / UjiNalar</span>
        <h1>Halaman ini memerlukan pengiriman kuis</h1>
        <p>Selesaikan seluruh pertanyaan untuk melihat hasil dan pembahasan.</p>
        <a class="button" href="{{ route('home') }}">Kembali ke Beranda <span aria-hidden="true">↗</span></a>
    </section>
@endsection
