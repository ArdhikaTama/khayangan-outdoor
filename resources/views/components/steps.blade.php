@props(['steps'])
<ol class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
    @foreach ($steps as $i => $s)
        <li class="rounded-lg bg-white p-6 ring-1 ring-forest/10">
            <div class="flex items-center justify-between">
                <span class="grid size-11 place-items-center rounded-full bg-forest text-white"><i data-lucide="{{ $s['icon'] }}" class="size-5"></i></span>
                <span class="text-3xl font-extrabold text-forest/15" aria-hidden="true">{{ $i + 1 }}</span>
            </div>
            <h3 class="mt-5 font-bold text-forest"><span class="sr-only">Langkah {{ $i + 1 }}: </span>{{ $s['judul'] }}</h3>
            <p class="mt-1.5 text-sm text-ink/70">{{ $s['ket'] }}</p>
        </li>
    @endforeach
</ol>
