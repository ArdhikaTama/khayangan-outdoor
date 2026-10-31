@props(['product'])
<article class="group flex flex-col overflow-hidden rounded-lg bg-white ring-1 ring-forest/10 transition hover:ring-forest/30">
    <div class="relative grid aspect-[4/3] place-items-center bg-beige text-forest/40">
        @if ($product['image'])
            <img src="{{ asset($product['image']) }}" alt="{{ $product['nama'] }}" loading="lazy" class="size-full object-cover">
        @else
            <i data-lucide="{{ $product['icon'] }}" class="size-14" aria-hidden="true"></i>
        @endif
        @if ($product['sample'] ?? false)<span class="absolute top-3 left-3 rounded-full bg-white/90 px-2.5 py-1 text-[11px] font-semibold text-muted">Data contoh</span>@endif
    </div>
    <div class="flex flex-1 flex-col p-5">
        <p class="text-xs text-muted">{{ $product['kategori'] }}</p>
        <h3 class="mt-1 line-clamp-2 min-h-[2.75rem] font-bold leading-snug text-forest">{{ $product['nama'] }}</h3>
        <p class="mt-1.5 line-clamp-2 text-sm text-ink/70">{{ $product['info'] }}</p>
        @if (($product['available_units'] ?? null) !== null)
            <p class="mt-3 text-xs font-semibold text-forest">{{ $product['available_units'] }} unit tersedia pada tanggal dipilih</p>
        @endif
        <p class="mt-auto pt-4 text-lg font-extrabold text-forest">Rp{{ number_format($product['harga'], 0, ',', '.') }}<span class="text-sm font-medium text-muted"> / hari</span></p>
        <a href="{{ route('katalog.show', $product['slug']) }}" class="btn btn-outline mt-4 !py-2.5">Lihat Detail</a>
    </div>
</article>
