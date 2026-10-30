@php
    $menu = [
        ['Beranda', 'home', 'home'], ['Katalog', 'katalog', 'katalog'], ['Cara Sewa', 'cara-sewa', 'cara-sewa'],
        ['Tentang Kami', 'tentang', 'tentang'], ['Blog', 'blog', 'blog'],
    ];
@endphp
<header x-data="{ open: false, profile: false }" @keydown.escape.window="open = false; profile = false"
        class="sticky top-0 z-40 border-b border-forest/10 bg-cream/95 backdrop-blur">
    <div class="container-page flex h-16 items-center justify-between gap-6">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-forest" aria-label="Khayangan Outdoor">
            <i data-lucide="mountain" class="size-7"></i>
            <span class="leading-none"><span class="block text-lg font-extrabold tracking-tight">KHAYANGAN</span><span class="block text-[9px] tracking-[0.35em] text-muted">OUTDOOR</span></span>
        </a>

        <nav class="hidden items-center gap-8 md:flex" aria-label="Navigasi utama">
            @foreach ($menu as [$label, $route, $pattern])
                <a href="{{ route($route) }}" @if (request()->routeIs($pattern)) aria-current="page" @endif
                   class="text-sm {{ request()->routeIs($pattern) ? 'font-bold text-forest' : 'text-ink/70 hover:text-forest' }}">{{ $label }}</a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('keranjang') }}" class="rounded-md p-2 text-forest hover:bg-beige" aria-label="Keranjang sewa"><i data-lucide="shopping-bag" class="size-5"></i></a>

            @auth
                <div class="relative hidden md:block">
                    <button @click="profile = !profile" :aria-expanded="profile" class="flex items-center gap-2 text-sm font-semibold text-forest">
                        {{ auth()->user()->name }} <i data-lucide="chevron-down" class="size-4"></i>
                    </button>
                    <div x-cloak x-show="profile" @click.outside="profile = false" class="absolute right-0 mt-3 w-48 rounded-md border border-forest/10 bg-white p-1.5 shadow-lg">
                        <a href="{{ route('keranjang') }}" class="block rounded px-3 py-2 text-sm hover:bg-cream">Penyewaan Saya</a>
                        <form method="POST" action="{{ url('/logout') }}">@csrf
                            <button class="w-full rounded px-3 py-2 text-left text-sm hover:bg-cream">Keluar</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('masuk') }}" class="hidden text-sm font-semibold text-forest md:block">Masuk</a>
                <a href="{{ route('daftar') }}" class="btn btn-primary hidden !py-2 md:inline-flex">Daftar</a>
            @endauth

            <button @click="open = !open" :aria-expanded="open" aria-controls="menu-mobile" class="rounded-md p-2 text-forest md:hidden" aria-label="Menu">
                <i data-lucide="menu" class="size-6" x-show="!open"></i><i data-lucide="x" class="size-6" x-cloak x-show="open"></i>
            </button>
        </div>
    </div>

    <nav id="menu-mobile" x-cloak x-show="open" x-transition.opacity class="border-t border-forest/10 bg-cream md:hidden" aria-label="Navigasi mobile">
        <div class="container-page flex flex-col py-3">
            @foreach ($menu as [$label, $route, $pattern])
                <a href="{{ route($route) }}" class="py-3 text-sm {{ request()->routeIs($pattern) ? 'font-bold text-forest' : 'text-ink/80' }}">{{ $label }}</a>
            @endforeach
            <div class="mt-2 flex gap-3 border-t border-forest/10 pt-4">
                @auth
                    <span class="py-2 text-sm font-semibold text-forest">{{ auth()->user()->name }}</span>
                @else
                    <a href="{{ route('masuk') }}" class="btn btn-outline flex-1">Masuk</a>
                    <a href="{{ route('daftar') }}" class="btn btn-primary flex-1">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>
</header>
