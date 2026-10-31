@if ($paginator->hasPages())
<nav role="navigation" aria-label="Halaman" class="flex flex-wrap items-center justify-center gap-1.5 text-sm">
    @if ($paginator->onFirstPage())
        <span class="rounded-md px-3 py-2 text-muted">Sebelumnya</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="rounded-md px-3 py-2 font-semibold text-forest hover:bg-beige">Sebelumnya</a>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element)) <span class="px-2 text-muted">{{ $element }}</span> @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span aria-current="page" class="grid size-9 place-items-center rounded-md bg-forest font-semibold text-white">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="grid size-9 place-items-center rounded-md text-forest hover:bg-beige" aria-label="Ke halaman {{ $page }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="rounded-md px-3 py-2 font-semibold text-forest hover:bg-beige">Berikutnya</a>
    @else
        <span class="rounded-md px-3 py-2 text-muted">Berikutnya</span>
    @endif
</nav>
@endif
