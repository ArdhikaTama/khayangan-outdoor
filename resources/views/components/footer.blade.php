<footer class="bg-deep text-white/80">
    <div class="container-page grid gap-10 py-14 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-white"><i data-lucide="mountain" class="size-7"></i><span class="text-lg font-extrabold tracking-tight">KHAYANGAN OUTDOOR</span></a>
            <p class="mt-4 max-w-xs text-sm leading-relaxed">Penyewaan perlengkapan outdoor untuk setiap petualang, tanpa harus memiliki semuanya.</p>
            <p class="mt-4 text-xs text-white/50">[Alamat lengkap — placeholder]</p>
        </div>
        <div>
            <h2 class="text-sm font-semibold text-white">Navigasi</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a class="hover:text-white" href="{{ route('home') }}">Beranda</a></li>
                <li><a class="hover:text-white" href="{{ route('katalog') }}">Katalog</a></li>
                <li><a class="hover:text-white" href="{{ route('cara-sewa') }}">Cara Sewa</a></li>
                <li><a class="hover:text-white" href="{{ route('tentang') }}">Tentang Kami</a></li>
                <li><a class="hover:text-white" href="{{ route('blog') }}">Blog</a></li>
            </ul>
        </div>
        <div>
            <h2 class="text-sm font-semibold text-white">Bantuan</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a class="hover:text-white" href="{{ route('faq') }}">FAQ</a></li>
                <li><a class="hover:text-white" href="{{ route('kebijakan') }}">Kebijakan Penyewaan</a></li>
                <li><a class="hover:text-white" href="{{ route('syarat') }}">Syarat dan Ketentuan</a></li>
                <li><a class="hover:text-white" href="{{ route('kontak') }}">Kontak</a></li>
            </ul>
        </div>
        <div>
            <h2 class="text-sm font-semibold text-white">Media Sosial</h2>
            {{-- Ganti dengan tautan asli saat tersedia --}}
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a class="inline-flex items-center gap-2 hover:text-white" href="{{ route('kontak') }}"><i data-lucide="camera" class="size-4"></i>Instagram (placeholder)</a></li>
                <li><a class="inline-flex items-center gap-2 hover:text-white" href="{{ route('kontak') }}"><i data-lucide="message-circle" class="size-4"></i>WhatsApp (placeholder)</a></li>
                <li><a class="inline-flex items-center gap-2 hover:text-white" href="{{ route('kontak') }}"><i data-lucide="mail" class="size-4"></i>Email (placeholder)</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-white/10 py-5 text-center text-xs text-white/50">© {{ date('Y') }} Khayangan Outdoor. Hak cipta dilindungi.</div>
</footer>
