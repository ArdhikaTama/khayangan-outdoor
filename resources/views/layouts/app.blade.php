<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Khayangan Outdoor') · Penyewaan Alat Outdoor</title>
    <meta name="description" content="@yield('description', 'Sewa perlengkapan outdoor andal tanpa harus memiliki. Dari kemah pertama hingga puncak berikutnya.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col">
    <a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-white focus:p-3">Lewati ke konten</a>
    <p class="bg-deep px-4 py-1.5 text-center text-[11px] text-white/80">Siapkan perlengkapan. Temukan cerita di perjalanan berikutnya.</p>
    <x-navbar />
    <main id="konten" class="flex-1">@yield('content')</main>
    <x-footer />
</body>
</html>
