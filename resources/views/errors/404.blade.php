@extends('layouts.app')
@section('title', 'Halaman tidak ditemukan')
@section('content')
    <section class="error-page">
        <span class="eyebrow">404 / UjiNalar</span>
        <h1>Halaman tidak ditemukan</h1>
        <p>Halaman atau kategori yang kamu cari tidak tersedia. Pilih kategori melalui beranda.</p>
        <a class="button" href="{{ route('home') }}">Kembali ke Beranda <span aria-hidden="true">↗</span></a>
    </section>
@endsection
