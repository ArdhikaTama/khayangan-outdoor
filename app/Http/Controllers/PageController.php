<?php

namespace App\Http\Controllers;

use App\Support\CatalogService;
use App\Support\DummyData;

class PageController extends Controller
{
    public function home(CatalogService $catalog)
    {
        return view('pages.home', [
            'categories' => array_slice(array_map(fn ($c) => $c + ['ket' => DummyData::categories()[array_search($c['slug'], array_column(DummyData::categories(), 'slug'))]['ket'] ?? '', 'icon' => $c['icon'] ?? 'compass'], $catalog->categories()), 0, 5),
            'products' => $catalog->featured(6),
            'steps' => DummyData::steps(),
            'posts' => DummyData::posts(),
        ]);
    }

    public function caraSewa() { return view('pages.cara-sewa', ['steps' => DummyData::steps()]); }
    public function tentang() { return $this->placeholder('Tentang Kami'); }
    public function blog() { return view('pages.blog', ['posts' => DummyData::posts()]); }

    public function placeholder(string $judul = 'Halaman', ?string $catatan = null)
    {
        return view('pages.placeholder', compact('judul', 'catatan'));
    }
}
