@extends('layouts.app')
@section('title', $item['nama'])
@section('content')
<section class="section"><div class="container-page">
    <nav aria-label="Breadcrumb" class="text-xs text-muted"><a href="{{ route('home') }}" class="hover:text-forest">Beranda</a> › <a href="{{ route('katalog') }}" class="hover:text-forest">Katalog</a> › <span class="text-forest">{{ $item['nama'] }}</span></nav>
    <div class="mt-6 grid gap-10 lg:grid-cols-2">
        <div class="grid aspect-[4/3] place-items-center overflow-hidden rounded-lg bg-beige text-forest/40">
            @if ($item['image'])<img src="{{ asset($item['image']) }}" alt="{{ $item['nama'] }}" class="size-full object-cover">@else<i data-lucide="{{ $item['icon'] }}" class="size-20"></i>@endif
        </div>
        <div>
            <p class="text-sm text-muted">{{ $item['kategori'] }}</p>
            <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-forest">{{ $item['nama'] }}</h1>
            <p class="mt-4 text-2xl font-extrabold text-forest">Rp{{ number_format($item['harga'], 0, ',', '.') }}<span class="text-base font-medium text-muted"> / hari</span></p>
            <p class="mt-5 leading-relaxed text-ink/80">{{ $item['deskripsi'] ?? $item['info'] }}</p>
            @if ($item['sample'] ?? false)<p class="mt-4 text-xs text-muted">Data contoh.</p>@endif
            <p class="mt-6 rounded-md bg-beige p-4 text-sm text-ink/80">Pilihan tanggal, ketersediaan unit, dan proses penyewaan akan tersedia di tahap berikutnya.</p>
            <a href="{{ route('katalog') }}" class="btn btn-outline mt-6">Kembali ke Katalog</a>
        </div>
    </div>
</div></section>
@endsection
