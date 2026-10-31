<?php

namespace App\Http\Controllers;

use App\Support\CatalogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatalogController extends Controller
{
    public function index(Request $request, CatalogService $catalog)
    {
        $rules = [
            'search' => 'nullable|string|max:100',
            'kategori' => 'nullable|string|max:100|alpha_dash',
            'harga_min' => 'nullable|integer|min:0|max:100000000',
            'harga_max' => ['nullable', 'integer', 'min:0', 'max:100000000'],
            'mulai' => 'nullable|date_format:Y-m-d|after_or_equal:today|required_with:selesai',
            'selesai' => 'nullable|date_format:Y-m-d|after_or_equal:mulai|required_with:mulai',
            'sort' => 'nullable|in:terbaru,nama,harga_asc,harga_desc',
        ];
        if ($request->filled('harga_min')) $rules['harga_max'][] = 'gte:harga_min';

        $v = Validator::make($request->query(), $rules, [
            'harga_max.gte' => 'Harga maksimum tidak boleh lebih kecil dari harga minimum.',
            'mulai.after_or_equal' => 'Tanggal mulai tidak boleh sudah berlalu.',
            'selesai.after_or_equal' => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
            'mulai.required_with' => 'Isi tanggal mulai dan tanggal selesai sekaligus.',
            'selesai.required_with' => 'Isi tanggal mulai dan tanggal selesai sekaligus.',
            '*.max' => 'Nilai terlalu besar atau terlalu panjang.',
            '*.integer' => 'Harga harus berupa angka.',
        ]);

        // Filter yang tidak valid diabaikan; filter lain tetap dipakai.
        $bad = $v->errors()->keys();
        if (array_intersect(['mulai', 'selesai'], $bad)) $bad = array_merge($bad, ['mulai', 'selesai']);
        $filters = collect($request->query())->except($bad)->all();

        $items = $catalog->search($filters);

        return view('pages.katalog', [
            'items' => $items,
            'categories' => $catalog->categories(),
            'filters' => $filters,
            'errors' => $v->errors(),
            'isSample' => ! $catalog->usesDatabase(),
            'sorts' => ['terbaru' => 'Terbaru', 'nama' => 'Nama A–Z', 'harga_asc' => 'Harga terendah', 'harga_desc' => 'Harga tertinggi'],
        ]);
    }

    public function show(string $slug, CatalogService $catalog)
    {
        $item = $catalog->find($slug) ?? abort(404);
        return view('pages.katalog-detail', ['item' => $item]);
    }
}
