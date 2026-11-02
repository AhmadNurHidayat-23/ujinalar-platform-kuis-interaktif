@extends('layouts.app')
@section('title', 'Ada kendala saat memuat halaman')
@section('content')
    <section class="error-page">
        <span class="eyebrow">500 / UjiNalar</span>
        <h1>Ada kendala saat memuat halaman</h1>
        <p>Silakan coba kembali beberapa saat lagi.</p>
        <a class="button" href="{{ route('home') }}">Kembali ke Beranda <span aria-hidden="true">↗</span></a>
    </section>
@endsection
