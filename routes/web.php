<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/katalog', [CatalogController::class, 'index'])->name('katalog');
Route::get('/katalog/{slug}', [CatalogController::class, 'show'])->name('katalog.show');

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/cara-sewa', 'caraSewa')->name('cara-sewa');
    Route::get('/tentang-kami', 'tentang')->name('tentang');
    Route::get('/blog', 'blog')->name('blog');

    // Placeholder sementara
    Route::get('/keranjang', 'placeholder')->defaults('judul', 'Keranjang Sewa')->name('keranjang');
    Route::get('/masuk', 'placeholder')->defaults('judul', 'Masuk')->name('masuk');
    Route::get('/daftar', 'placeholder')->defaults('judul', 'Daftar')->name('daftar');
    Route::get('/faq', 'placeholder')->defaults('judul', 'FAQ')->name('faq');
    Route::get('/kebijakan-penyewaan', 'placeholder')->defaults('judul', 'Kebijakan Penyewaan')->name('kebijakan');
    Route::get('/syarat-ketentuan', 'placeholder')->defaults('judul', 'Syarat dan Ketentuan')->name('syarat');
    Route::get('/kontak', 'placeholder')->defaults('judul', 'Kontak')->name('kontak');
});
