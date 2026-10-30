@extends('layouts.app')

@section('content')
@php $hero = file_exists(public_path('images/hero.jpg')) ? asset('images/hero.jpg') : null; @endphp

{{-- HERO: letakkan foto di public/images/hero.jpg --}}
<section class="relative isolate overflow-hidden bg-deep text-white"
         @if ($hero) style="background:url('{{ $hero }}') center/cover" @endif>
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-deep/95 via-forest/70 to-forest/10"></div>
    <div class="container-page flex min-h-[28rem] flex-col justify-center py-20 sm:min-h-[34rem] lg:min-h-[38rem]">
        <p class="text-xs font-semibold tracking-widest text-white/80 uppercase">Penyewaan Alat Outdoor</p>
        <h1 class="mt-5 max-w-xl text-4xl font-extrabold leading-[1.05] tracking-tight sm:text-6xl">Lebih dekat alam.<br>Lebih jauh melangkah.</h1>
        <p class="mt-6 max-w-md text-base leading-relaxed text-white/85">Perlengkapan outdoor andal tanpa harus memiliki. Dari kemah pertama hingga puncak berikutnya.</p>
        <div class="mt-8 flex flex-wrap items-center gap-4">
            <a href="{{ route('katalog') }}" class="btn btn-light">Jelajahi Perlengkapan <i data-lucide="arrow-up-right" class="size-4 text-orange-600"></i></a>
            <a href="{{ route('cara-sewa') }}" class="link-arrow !text-white">Cara Sewa <i data-lucide="arrow-up-right" class="size-4"></i></a>
        </div>
        <p class="mt-12 inline-flex items-center gap-1.5 text-xs text-white/70 sm:absolute sm:right-8 sm:bottom-6"><i data-lucide="map-pin" class="size-3.5"></i>[Lokasi — placeholder]</p>
    </div>
</section>

{{-- AVAILABILITY --}}
<section class="bg-beige" aria-labelledby="judul-rencana" x-data="availability({ mulai: '{{ request('mulai') }}', selesai: '{{ request('selesai') }}' })">
    <div class="container-page grid gap-6 py-10 lg:grid-cols-[1fr_2fr] lg:items-end">
        <div>
            <p class="eyebrow">Rencanakan Perjalanan</p>
            <h2 id="judul-rencana" class="mt-1 text-2xl font-extrabold text-forest">Kapan kamu berangkat?</h2>
            <p class="mt-1 text-sm text-muted">Lihat stok sesuai tanggal sewamu.</p>
        </div>
        <form method="GET" action="{{ route('katalog') }}" novalidate @submit.prevent="submit($event)">
            <div class="grid gap-4 sm:grid-cols-[1fr_1fr_auto] sm:items-end">
                <label class="block text-xs font-semibold text-forest">Tanggal mulai
                    <input type="date" name="mulai" x-model="mulai" :min="today" @change="syncEnd(); error = ''" class="mt-1.5 w-full rounded-md border border-forest/15 bg-white px-3 py-3 text-sm font-normal text-ink">
                </label>
                <label class="block text-xs font-semibold text-forest">Tanggal selesai
                    <input type="date" name="selesai" x-model="selesai" :min="mulai || today" @change="error = ''" class="mt-1.5 w-full rounded-md border border-forest/15 bg-white px-3 py-3 text-sm font-normal text-ink">
                </label>
                <button type="submit" class="btn btn-primary">Cek Ketersediaan <i data-lucide="arrow-up-right" class="size-4"></i></button>
            </div>
            <p class="mt-3 text-xs text-muted" x-text="ringkasan" aria-live="polite"></p>
            <p x-cloak x-show="error" x-text="error" role="alert" class="mt-2 text-sm font-semibold text-red-700"></p>
        </form>
    </div>
</section>

{{-- KATEGORI --}}
<section class="section" aria-labelledby="judul-kategori">
    <div class="container-page">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div><p class="eyebrow">Perlengkapan untuk Setiap Rencana</p>
                <h2 id="judul-kategori" class="h-section">Tujuanmu berbeda. Kesiapanmu tetap.</h2></div>
            <a href="{{ route('katalog') }}" class="link-arrow">Semua Kategori <i data-lucide="arrow-up-right" class="size-4"></i></a>
        </div>
        <ul class="mt-8 grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-5">
            @foreach ($categories as $c)
                <li><a href="{{ route('katalog', ['kategori' => $c['slug']]) }}" class="flex h-full items-center gap-3 rounded-lg bg-beige p-4 transition hover:-translate-y-0.5 hover:bg-[#e2dccd]">
                    <i data-lucide="{{ $c['icon'] }}" class="size-6 shrink-0 text-forest"></i>
                    <span><span class="block text-sm font-bold text-forest">{{ $c['nama'] }}</span><span class="block text-xs text-muted">{{ $c['ket'] }}</span></span>
                </a></li>
            @endforeach
        </ul>
    </div>
</section>

{{-- PRODUK UNGGULAN --}}
<section class="pb-16 sm:pb-20" aria-labelledby="judul-produk">
    <div class="container-page">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <h2 id="judul-produk" class="h-section !mt-0">Produk Unggulan</h2>
            <a href="{{ route('katalog') }}" class="link-arrow">Lihat Katalog <i data-lucide="arrow-up-right" class="size-4"></i></a>
        </div>
        <p class="mt-2 text-xs text-muted">Contoh tampilan dengan data dummy. Stok dan harga akan mengikuti database.</p>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($products as $p) <x-product-card :product="$p" /> @endforeach
        </div>
    </div>
</section>

{{-- CARA SEWA --}}
<section class="bg-beige section" aria-labelledby="judul-cara">
    <div class="container-page">
        <p class="eyebrow">Cara Sewa</p>
        <h2 id="judul-cara" class="h-section mb-8">Empat langkah menuju perjalananmu</h2>
        <x-steps :steps="$steps" />
    </div>
</section>

{{-- BLOG --}}
<section class="section" aria-labelledby="judul-blog">
    <div class="container-page">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div><h2 id="judul-blog" class="h-section !mt-0">Cerita dan Inspirasi Petualangan</h2>
                <p class="mt-2 max-w-lg text-sm text-ink/70">Temukan tips, panduan, dan inspirasi untuk perjalanan outdoor berikutnya.</p></div>
            <a href="{{ route('blog') }}" class="link-arrow">Lihat Semua Artikel <i data-lucide="arrow-up-right" class="size-4"></i></a>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach ($posts as $post) <x-blog-card :post="$post" /> @endforeach
        </div>
    </div>
</section>

{{-- TENTANG --}}
<section class="bg-beige section" aria-labelledby="judul-tentang">
    <div class="container-page grid items-center gap-10 lg:grid-cols-2">
        <div>
            <p class="eyebrow">Tentang Kami</p>
            <h2 id="judul-tentang" class="h-section">Khayangan Outdoor</h2>
            <p class="mt-4 max-w-md leading-relaxed text-ink/80">Khayangan Outdoor hadir untuk membantu setiap petualang mendapatkan perlengkapan yang dibutuhkan tanpa harus memiliki semuanya.</p>
            <p class="mt-3 text-xs text-muted">[Profil bisnis lengkap — placeholder]</p>
            <a href="{{ route('tentang') }}" class="btn btn-primary mt-6">Kenali Kami</a>
        </div>
        <div class="grid aspect-[4/3] place-items-center rounded-lg bg-forest/10 text-forest/40" role="img" aria-label="Foto aktivitas outdoor (placeholder)">
            <i data-lucide="tent" class="size-16"></i>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="bg-forest py-16 text-center text-white sm:py-20">
    <div class="container-page">
        <h2 class="mx-auto max-w-2xl text-3xl font-extrabold tracking-tight sm:text-4xl">Petualangan berikutnya dimulai dari sini.</h2>
        <p class="mx-auto mt-4 max-w-xl text-white/80">Temukan perlengkapan yang kamu butuhkan dan persiapkan perjalananmu bersama Khayangan Outdoor.</p>
        <a href="{{ route('katalog') }}" class="btn btn-light mt-8">Jelajahi Katalog <i data-lucide="arrow-up-right" class="size-4"></i></a>
    </div>
</section>
@endsection
