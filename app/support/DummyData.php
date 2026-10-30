<?php

namespace App\Support;

/**
 * Data dummy tampilan. Ganti dengan Eloquent (Category, Product, Post)
 * di PageController tanpa mengubah Blade: kuncinya sengaja dibuat sama.
 * 'image' => null memakai ikon sebagai pengganti; isi dengan path di /public/images saat foto tersedia.
 */
class DummyData
{
    public static function categories(): array
    {
        return [
            ['slug' => 'tenda', 'nama' => 'Tenda', 'ket' => 'Untuk berkemah', 'icon' => 'tent'],
            ['slug' => 'tas-carrier', 'nama' => 'Tas & Carrier', 'ket' => 'Untuk melangkah', 'icon' => 'backpack'],
            ['slug' => 'perlengkapan-tidur', 'nama' => 'Perlengkapan Tidur', 'ket' => 'Untuk beristirahat', 'icon' => 'bed-double'],
            ['slug' => 'peralatan-masak', 'nama' => 'Peralatan Masak', 'ket' => 'Untuk mengisi energi', 'icon' => 'cooking-pot'],
            ['slug' => 'penerangan', 'nama' => 'Penerangan', 'ket' => 'Untuk menerangi perjalanan', 'icon' => 'lamp'],
        ];
    }

    public static function products(): array
    {
        return [
            ['slug' => 'tenda-dome-2', 'nama' => 'Tenda Dome 2 Orang', 'kategori' => 'Tenda', 'harga' => 50000, 'info' => 'Ringan, double layer, cocok untuk pendakian.', 'icon' => 'tent', 'image' => null],
            ['slug' => 'tenda-dome-4', 'nama' => 'Tenda Dome 4 Orang', 'kategori' => 'Tenda', 'harga' => 85000, 'info' => 'Ruang lega untuk keluarga atau kelompok kecil.', 'icon' => 'tent', 'image' => null],
            ['slug' => 'carrier-50l', 'nama' => 'Carrier 50 Liter', 'kategori' => 'Tas & Carrier', 'harga' => 40000, 'info' => 'Sistem punggung nyaman untuk 2-3 hari.', 'icon' => 'backpack', 'image' => null],
            ['slug' => 'sleeping-bag', 'nama' => 'Sleeping Bag', 'kategori' => 'Perlengkapan Tidur', 'harga' => 25000, 'info' => 'Hangat, ringkas, mudah dilipat.', 'icon' => 'bed-double', 'image' => null],
            ['slug' => 'kompor-portable', 'nama' => 'Kompor Portable', 'kategori' => 'Peralatan Masak', 'harga' => 20000, 'info' => 'Kompor lipat untuk masak cepat di camp.', 'icon' => 'flame', 'image' => null],
            ['slug' => 'matras-camping', 'nama' => 'Matras Camping', 'kategori' => 'Perlengkapan Tidur', 'harga' => 10000, 'info' => 'Alas tidur ringan dan tahan lembap.', 'icon' => 'bed-single', 'image' => null],
        ];
    }

    public static function steps(): array
    {
        return [
            ['icon' => 'search', 'judul' => 'Pilih Perlengkapan', 'ket' => 'Temukan perlengkapan yang dibutuhkan.'],
            ['icon' => 'calendar-days', 'judul' => 'Tentukan Tanggal', 'ket' => 'Pilih periode penyewaan.'],
            ['icon' => 'wallet', 'judul' => 'Lakukan Pembayaran', 'ket' => 'Selesaikan pembayaran sesuai tagihan.'],
            ['icon' => 'package-check', 'judul' => 'Ambil Perlengkapan', 'ket' => 'Ambil barang setelah pembayaran terverifikasi.'],
        ];
    }

    public static function posts(): array
    {
        return [
            ['slug' => 'memilih-tenda-pemula', 'judul' => 'Panduan Memilih Tenda untuk Pendaki Pemula', 'kategori' => 'Panduan Camping', 'ringkasan' => 'Kapasitas, bobot, dan ketahanan cuaca: tiga hal yang perlu dicek sebelum menyewa tenda.', 'tanggal' => '2026-10-12', 'image' => null],
            ['slug' => 'checklist-mendaki', 'judul' => 'Checklist Perlengkapan Sebelum Mendaki Gunung', 'kategori' => 'Tips Pendakian', 'ringkasan' => 'Daftar periksa praktis agar tidak ada yang tertinggal di basecamp.', 'tanggal' => '2026-10-05', 'image' => null],
            ['slug' => 'merawat-carrier', 'judul' => 'Tips Merawat Carrier agar Lebih Awet', 'kategori' => 'Review Perlengkapan', 'ringkasan' => 'Cara membersihkan dan menyimpan carrier supaya tetap nyaman dipakai.', 'tanggal' => '2026-09-28', 'image' => null],
        ];
    }
}
