@extends('layouts.app')
@section('title', 'Katalog')

@section('content')
@php
    $f = $filters;
    $presets = [['Rp0–25.000', 0, 25000], ['Rp25.000–50.000', 25000, 50000], ['Rp50.000–100.000', 50000, 100000], ['Di atas Rp100.000', 100000, '']];
@endphp
<div x-data="{ drawer: false, min: '{{ $f['harga_min'] ?? '' }}', max: '{{ $f['harga_max'] ?? '' }}' }" @keydown.escape.window="drawer = false">
    <section class="border-b border-forest/10 bg-beige/60">
        <div class="container-page py-8">
            <nav aria-label="Breadcrumb" class="text-xs text-muted"><a href="{{ route('home') }}" class="hover:text-forest">Beranda</a> <span aria-hidden="true">›</span> <span class="text-forest" aria-current="page">Katalog</span></nav>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-forest sm:text-4xl">Temukan Perlengkapan Petualanganmu</h1>
            <p class="mt-2 max-w-xl text-sm text-ink/70">Jelajahi berbagai perlengkapan outdoor berkualitas untuk menemani setiap perjalananmu.</p>
            <div class="mt-6 flex max-w-2xl gap-2">
                <label class="relative flex-1"><span class="sr-only">Cari perlengkapan</span>
                    <i data-lucide="search" class="pointer-events-none absolute top-1/2 left-3.5 size-4 -translate-y-1/2 text-muted"></i>
                    <input form="filter-form" type="search" name="search" value="{{ $f['search'] ?? '' }}" maxlength="100" placeholder="Cari tenda, carrier, sleeping bag, dan lainnya..." class="w-full rounded-md border border-forest/15 bg-white py-3 pr-3 pl-10 text-sm">
                </label>
                <button form="filter-form" type="submit" class="btn btn-primary">Cari</button>
            </div>
        </div>
    </section>

    <div class="container-page grid gap-8 py-10 lg:grid-cols-[16rem_1fr]">
        {{-- FILTER (sidebar desktop, drawer mobile) --}}
        <aside :class="drawer ? 'fixed inset-0 z-50 block overflow-y-auto bg-white p-5' : 'hidden lg:block'" aria-label="Filter katalog">
            <div class="mb-4 flex items-center justify-between lg:hidden">
                <h2 class="font-bold text-forest">Filter</h2>
                <button type="button" @click="drawer = false" class="rounded-md p-2" aria-label="Tutup filter"><i data-lucide="x" class="size-5"></i></button>
            </div>
            <form id="filter-form" method="GET" action="{{ route('katalog') }}" novalidate
                  x-data="availability({ mulai: '{{ $f['mulai'] ?? '' }}', selesai: '{{ $f['selesai'] ?? '' }}' }, true)" @submit.prevent="submit($event)" class="space-y-7">
                <fieldset>
                    <legend class="mb-3 text-sm font-bold text-forest">Kategori</legend>
                    <div class="space-y-2 text-sm">
                        <label class="flex items-center gap-2"><input type="radio" name="kategori" value="" @checked(empty($f['kategori'])) class="accent-forest"> Semua</label>
                        @foreach ($categories as $c)
                            <label class="flex items-center gap-2"><input type="radio" name="kategori" value="{{ $c['slug'] }}" @checked(($f['kategori'] ?? '') === $c['slug']) class="accent-forest"> {{ $c['nama'] }}</label>
                        @endforeach
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="mb-3 text-sm font-bold text-forest">Harga sewa per hari</legend>
                    <div class="mb-3 flex flex-wrap gap-1.5">
                        @foreach ($presets as [$label, $lo, $hi])
                            <button type="button" @click="min = '{{ $lo }}'; max = '{{ $hi }}'" class="rounded-full bg-beige px-3 py-1.5 text-xs text-forest hover:bg-[#e2dccd]">{{ $label }}</button>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="number" name="harga_min" x-model="min" min="0" step="1000" placeholder="Min" aria-label="Harga minimum" class="w-full rounded-md border border-forest/15 bg-white px-3 py-2.5 text-sm">
                        <span class="text-muted">–</span>
                        <input type="number" name="harga_max" x-model="max" min="0" step="1000" placeholder="Maks" aria-label="Harga maksimum" class="w-full rounded-md border border-forest/15 bg-white px-3 py-2.5 text-sm">
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="mb-3 text-sm font-bold text-forest">Ketersediaan</legend>
                    <div class="space-y-3">
                        <label class="block text-xs font-semibold text-forest">Tanggal mulai
                            <input type="date" name="mulai" x-model="mulai" :min="today" @change="syncEnd(); error = ''" class="mt-1.5 w-full rounded-md border border-forest/15 bg-white px-3 py-2.5 text-sm font-normal"></label>
                        <label class="block text-xs font-semibold text-forest">Tanggal selesai
                            <input type="date" name="selesai" x-model="selesai" :min="mulai || today" @change="error = ''" class="mt-1.5 w-full rounded-md border border-forest/15 bg-white px-3 py-2.5 text-sm font-normal"></label>
                    </div>
                    <p class="mt-2 text-xs text-muted" x-text="ringkasan" aria-live="polite"></p>
                    <p x-cloak x-show="error" x-text="error" role="alert" class="mt-2 text-xs font-semibold text-red-700"></p>
                </fieldset>

                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary flex-1">Terapkan Filter</button>
                    <a href="{{ route('katalog') }}" class="btn btn-outline">Reset</a>
                </div>
            </form>
        </aside>

        {{-- DAFTAR PRODUK --}}
        <div>
            @if ($errors->any())
                <div role="alert" class="mb-5 rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                    <p class="font-semibold">Beberapa filter tidak dipakai:</p>
                    <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $m)<li>{{ $m }}</li>@endforeach</ul>
                </div>
            @endif
            @if ($isSample)
                <p class="mb-5 rounded-md bg-beige p-3 text-xs text-ink/80">Tabel perlengkapan belum berisi data, jadi yang tampil adalah <strong>data contoh</strong>. Filter tanggal belum menghitung ketersediaan unit pada mode ini.</p>
            @endif

            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <button type="button" @click="drawer = true" class="btn btn-outline !py-2 lg:hidden"><i data-lucide="search" class="size-4"></i> Filter</button>
                    <p class="text-sm text-muted"><strong class="text-forest">{{ $items->total() }}</strong> perlengkapan ditemukan</p>
                </div>
                <label class="flex items-center gap-2 text-sm text-muted">Urutkan
                    <select form="filter-form" name="sort" @change="$el.form.requestSubmit()" class="rounded-md border border-forest/15 bg-white py-2 pr-8 pl-3 text-sm text-ink">
                        @foreach ($sorts as $key => $label)<option value="{{ $key }}" @selected(($f['sort'] ?? 'terbaru') === $key)>{{ $label }}</option>@endforeach
                    </select>
                </label>
            </div>

            @if ($items->count())
                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($items as $p) <x-product-card :product="$p" /> @endforeach
                </div>
                <div class="mt-10">{{ $items->links('vendor.pagination.khayangan') }}</div>
            @else
                <div class="rounded-lg bg-white p-10 text-center ring-1 ring-forest/10">
                    <i data-lucide="compass" class="mx-auto size-10 text-forest/40"></i>
                    <h2 class="mt-4 text-lg font-bold text-forest">Perlengkapan tidak ditemukan.</h2>
                    <p class="mx-auto mt-1 max-w-sm text-sm text-ink/70">Maaf, kami belum menemukan perlengkapan yang sesuai dengan pencarianmu.</p>
                    <a href="{{ route('katalog') }}" class="btn btn-primary mt-5">Reset Filter</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
