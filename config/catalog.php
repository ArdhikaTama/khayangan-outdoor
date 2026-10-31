<?php

/**
 * PEMETAAN SKEMA DATABASE -> KATALOG.
 * Sesuaikan nama tabel/kolom di sini dengan migration proyek Anda. Tidak perlu ubah kode lain.
 */
return [
    'per_page' => 12,

    'equipment' => [
        'table' => 'equipment', 'id' => 'id', 'category_id' => 'category_id',
        'name' => 'name', 'slug' => 'slug', 'description' => 'description',
        'price' => 'price_per_day', 'image' => 'image_path', 'created_at' => 'created_at',
    ],
    'categories' => ['table' => 'categories', 'id' => 'id', 'name' => 'name', 'slug' => 'slug'],

    // Unit fisik. Hanya unit dengan status = 'rentable' yang dihitung.
    'units' => ['table' => 'equipment_units', 'id' => 'id', 'equipment_id' => 'equipment_id', 'status' => 'condition_status', 'rentable' => 'good'],

    // Alokasi unit ke penyewaan. Status = 'released' tidak mengunci unit.
    'allocations' => ['table' => 'rental_unit_allocations', 'unit_id' => 'equipment_unit_id', 'start' => 'start_date', 'end' => 'end_date', 'status' => 'status', 'released' => 'released'],
];
