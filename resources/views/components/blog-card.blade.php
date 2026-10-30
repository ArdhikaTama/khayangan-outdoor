@props(['post'])
<article class="flex flex-col overflow-hidden rounded-lg bg-white ring-1 ring-forest/10">
    <div class="grid aspect-[16/10] place-items-center bg-beige text-forest/40">
        @if ($post['image'])
            <img src="{{ asset($post['image']) }}" alt="" loading="lazy" class="size-full object-cover">
        @else
            <i data-lucide="mountain" class="size-12" aria-hidden="true"></i>
        @endif
    </div>
    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center gap-3 text-xs">
            <span class="rounded-full bg-beige px-2.5 py-1 font-semibold text-forest">{{ $post['kategori'] }}</span>
            <time datetime="{{ $post['tanggal'] }}" class="text-muted">{{ \Carbon\Carbon::parse($post['tanggal'])->locale('id')->translatedFormat('j F Y') }}</time>
        </div>
        <h3 class="mt-3 font-bold leading-snug text-forest">{{ $post['judul'] }}</h3>
        <p class="mt-2 flex-1 text-sm text-ink/70">{{ $post['ringkasan'] }}</p>
        <a href="{{ route('blog') }}" class="link-arrow mt-4">Baca Selengkapnya <i data-lucide="arrow-up-right" class="size-4"></i></a>
    </div>
</article>
