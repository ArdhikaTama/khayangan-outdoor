@extends('layouts.app')
@section('title', 'Cara Sewa')
@section('content')
<section class="section"><div class="container-page">
    <h1 class="h-section mb-8">Cara Sewa</h1>
    <x-steps :steps="$steps" />
</div></section>
@endsection
