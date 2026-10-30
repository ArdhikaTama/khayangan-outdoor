@props(['product'])
<article class="group flex flex-col overflow-hidden rounded-lg bg-white ring-1 ring-forest/10 transition hover:ring-forest/30">
    <div class="grid aspect-[4/3] place-items-center bg-beige text-forest/40">
        @if ($product['image'])
            <img src="{{ asset($product['image']) }}" alt="{{ $product['nama'] }}" loading="lazy" class="size-full object-cover">
        @else
            <i data-lucide="{{ $product['icon'] }}" class="size-14" aria-hidden="true"></i>
        @endif
    </div>
    <div class="flex flex-1 flex-col p-5">
        <p class="text-xs text-muted">{{ $product['kategori'] }}</p>
        <h3 class="mt-1 font-bold text-forest">{{ $product['nama'] }}</h3>
        <p class="mt-1.5 text-sm text-ink/70">{{ $product['info'] }}</p>
        <p class="mt-4 text-lg font-extrabold text-forest">Rp{{ number_format($product['harga'], 0, ',', '.') }}<span class="text-sm font-medium text-muted">/hari</span></p>
        <a href="{{ route('katalog') }}" class="btn btn-outline mt-4 !py-2.5">Lihat Detail</a>
    </div>
</article>
