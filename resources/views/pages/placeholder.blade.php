@extends('layouts.app')
@section('title', $judul)
@section('content')
<section class="section"><div class="container-page max-w-2xl">
    <h1 class="h-section">{{ $judul }}</h1>
    <p class="mt-4 text-ink/70">{{ $catatan ?? 'Halaman ini sedang disiapkan.' }}</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-6">Kembali ke Beranda</a>
</div></section>
@endsection
