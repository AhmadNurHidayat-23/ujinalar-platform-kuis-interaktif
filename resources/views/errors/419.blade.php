@extends('layouts.app')
@section('title', 'Sesi telah berakhir')
@section('content')
    <section class="error-page">
        <span class="eyebrow">419 / UjiNalar</span>
        <h1>Sesi telah berakhir</h1>
        <p>Muat ulang halaman kuis, lalu isi dan kirim kembali jawabanmu.</p>
        <a class="button" href="{{ route('home') }}">Kembali ke Beranda <span aria-hidden="true">↗</span></a>
    </section>
@endsection
