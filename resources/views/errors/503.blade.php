@extends('layouts.app')
@section('title', 'UjiNalar sedang dirawat')
@section('content')
    <section class="error-page">
        <span class="eyebrow">503 / UjiNalar</span>
        <h1>UjiNalar sedang dirawat</h1>
        <p>Silakan kembali beberapa saat lagi untuk melanjutkan kuis.</p>
        <a class="button" href="{{ route('home') }}">Kembali ke Beranda <span aria-hidden="true">↗</span></a>
    </section>
@endsection
