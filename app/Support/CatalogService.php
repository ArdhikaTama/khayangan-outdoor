<?php

namespace App\Support;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Query katalog. Memakai database bila tabel equipment ada dan berisi;
 * jika tidak, memakai DummyData dan menandai item sebagai contoh ('sample' => true).
 */
class CatalogService
{
    private array $c;

    public function __construct()
    {
        $this->c = config('catalog');
    }

    public function usesDatabase(): bool
    {
        $t = $this->c['equipment']['table'];
        return Schema::hasTable($t) && DB::table($t)->exists();
    }

    public function categories(): array
    {
        $k = $this->c['categories'];
        if ($this->usesDatabase() && Schema::hasTable($k['table'])) {
            return DB::table($k['table'])->orderBy($k['name'])->get()
                ->map(fn($r) => ['slug' => $r->{$k['slug']}, 'nama' => $r->{$k['name']}])->all();
        }
        return array_map(fn($x) => ['slug' => $x['slug'], 'nama' => $x['nama'], 'ket' => $x['ket'], 'icon' => $x['icon']], DummyData::categories());
    }

    public function featured(int $n = 6): array
    {
        return $this->search([], $n)->items();
    }

    public function find(string $slug): ?array
    {
        if ($this->usesDatabase()) {
            $e = $this->c['equipment'];
            $k = $this->c['categories'];
            $row = $this->base()->where("{$e['table']}.{$e['slug']}", $slug)->first();
            return $row ? $this->map($row) : null;
        }
        return collect(DummyData::products())->firstWhere('slug', $slug) + ['sample' => true, 'available_units' => null];
    }

    public function search(array $f, ?int $perPage = null): LengthAwarePaginator
    {
        $perPage ??= $this->c['per_page'];
        return $this->usesDatabase() ? $this->searchDb($f, $perPage) : $this->searchDummy($f, $perPage);
    }

    private function base()
    {
        $e = $this->c['equipment'];
        $k = $this->c['categories'];
        return DB::table($e['table'])
            ->leftJoin($k['table'], "{$k['table']}.{$k['id']}", '=', "{$e['table']}.{$e['category_id']}")
            ->select("{$e['table']}.*", "{$k['table']}.{$k['name']} as category_name", "{$k['table']}.{$k['slug']} as category_slug");
    }

    /** Subquery: jumlah unit fisik layak sewa dan bebas pada periode (inklusif). */
    private function availableUnits(string $start, string $end)
    {
        $u = $this->c['units'];
        $a = $this->c['allocations'];
        $e = $this->c['equipment'];
        return DB::table($u['table'])->selectRaw('count(*)')
            ->whereColumn("{$u['table']}.{$u['equipment_id']}", "{$e['table']}.{$e['id']}")
            ->where("{$u['table']}.{$u['status']}", $u['rentable'])
            ->whereNotExists(fn($q) => $q->selectRaw('1')->from($a['table'])
                ->whereColumn("{$a['table']}.{$a['unit_id']}", "{$u['table']}.{$u['id']}")
                ->where("{$a['table']}.{$a['status']}", '!=', $a['released'])
                ->where("{$a['table']}.{$a['start']}", '<=', $end)
                ->where("{$a['table']}.{$a['end']}", '>=', $start));
    }

    private function searchDb(array $f, int $perPage): LengthAwarePaginator
    {
        $e = $this->c['equipment'];
        $k = $this->c['categories'];
        $q = $this->base();

        if (! empty($f['search'])) $q->where("{$e['table']}.{$e['name']}", 'like', '%' . addcslashes($f['search'], '%_\\') . '%');
        if (! empty($f['kategori'])) $q->where("{$k['table']}.{$k['slug']}", $f['kategori']);
        if (isset($f['harga_min']) && $f['harga_min'] !== '') $q->where("{$e['table']}.{$e['price']}", '>=', $f['harga_min']);
        if (isset($f['harga_max']) && $f['harga_max'] !== '') $q->where("{$e['table']}.{$e['price']}", '<=', $f['harga_max']);

        if (! empty($f['mulai']) && ! empty($f['selesai'])) {
            $sub = $this->availableUnits($f['mulai'], $f['selesai']);
            $q->selectSub($this->availableUnits($f['mulai'], $f['selesai']), 'available_units')
                ->whereRaw('(' . $sub->toSql() . ') > 0', $sub->getBindings());
        }

        match ($f['sort'] ?? 'terbaru') {
            'nama' => $q->orderBy("{$e['table']}.{$e['name']}"),
            'harga_asc' => $q->orderBy("{$e['table']}.{$e['price']}"),
            'harga_desc' => $q->orderByDesc("{$e['table']}.{$e['price']}"),
            default => $q->orderByDesc("{$e['table']}.{$e['created_at']}"),
        };

        $p = $q->paginate($perPage)->withQueryString();
        $p->setCollection($p->getCollection()->map(fn($r) => $this->map($r)));
        return $p;
    }

    private function searchDummy(array $f, int $perPage): LengthAwarePaginator
    {
        $cats = collect(DummyData::categories())->pluck('nama', 'slug');
        $items = collect(DummyData::products())->map(fn($p) => $p + ['sample' => true, 'available_units' => null])
            ->filter(fn($p) => empty($f['search']) || Str::contains(Str::lower($p['nama']), Str::lower($f['search'])))
            ->filter(fn($p) => empty($f['kategori']) || ($cats[$f['kategori']] ?? null) === $p['kategori'])
            ->filter(fn($p) => ! isset($f['harga_min']) || $f['harga_min'] === '' || $p['harga'] >= $f['harga_min'])
            ->filter(fn($p) => ! isset($f['harga_max']) || $f['harga_max'] === '' || $p['harga'] <= $f['harga_max']);

        $items = (match ($f['sort'] ?? 'terbaru') {
            'nama' => $items->sortBy('nama'),
            'harga_asc' => $items->sortBy('harga'),
            'harga_desc' => $items->sortByDesc('harga'),
            default => $items,
        })->values();

        return new LengthAwarePaginator(
            $items->forPage(LengthAwarePaginator::resolveCurrentPage(), $perPage)->values(),
            $items->count(),
            $perPage,
            LengthAwarePaginator::resolveCurrentPage(),
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => request()->query()]
        );
    }

    private function map(object $r): array
    {
        $e = $this->c['equipment'];
        $img = $r->{$e['image']} ?? null;
        $icons = ['tenda' => 'tent', 'tas-carrier' => 'backpack', 'perlengkapan-tidur' => 'bed-double', 'peralatan-masak' => 'cooking-pot', 'penerangan' => 'lamp'];
        return [
            'slug' => $r->{$e['slug']},
            'nama' => $r->{$e['name']},
            'kategori' => $r->category_name ?? '-',
            'harga' => (int) $r->{$e['price']},
            'info' => Str::limit(strip_tags((string) ($r->{$e['description']} ?? '')), 90),
            'deskripsi' => $r->{$e['description']} ?? '',
            'icon' => $icons[$r->category_slug ?? ''] ?? 'compass',
            'image' => $img ? (Str::startsWith($img, ['http', '/']) ? $img : 'storage/' . $img) : null,
            'available_units' => isset($r->available_units) ? (int) $r->available_units : null,
            'sample' => false,
        ];
    }
}
