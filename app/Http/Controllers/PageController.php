<?php

namespace App\Http\Controllers;

use App\support\DummyData;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'categories' => DummyData::categories(),
            'products'   => DummyData::products(),
            'steps'      => DummyData::steps(),
            'posts'      => DummyData::posts(),
        ]);
    }

    public function katalog()
    {
        return $this->placeholder('Katalog Perlengkapan', 'Halaman katalog akan menampilkan produk dari database dan menerima filter kategori (?kategori=) serta tanggal (?mulai=&selesai=).');
    }

    public function caraSewa()
    {
        return view('pages.cara-sewa', ['steps' => DummyData::steps()]);
    }

    public function tentang()
    {
        return $this->placeholder('Tentang Kami');
    }

    public function blog()
    {
        return view('pages.blog', ['posts' => DummyData::posts()]);
    }

    public function placeholder(string $judul = 'Halaman', ?string $catatan = null)
    {
        return view('pages.placeholder', compact('judul', 'catatan'));
    }
}
