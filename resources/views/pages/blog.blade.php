@extends('layouts.app')
@section('title', 'Blog')
@section('content')
<section class="section"><div class="container-page">
    <h1 class="h-section">Cerita dan Inspirasi Petualangan</h1>
    <div class="mt-8 grid gap-6 md:grid-cols-3">@foreach ($posts as $post) <x-blog-card :post="$post" /> @endforeach</div>
</div></section>
@endsection
