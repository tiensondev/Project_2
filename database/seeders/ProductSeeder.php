<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $msiMouseId = DB::table('products')->insertGetId([
            'name' => '[Mới 100%] Chuột Gaming MSI M99 Pro',
            'original_price' => 499000,
            'discount_percent' => 40,
            'current_price' => 300000,
            'image' => 'msi_m99_pro.jpg',
            'category_id' => 1, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $laptopId = DB::table('products')->insertGetId([
            'name' => 'Laptop Gaming Acer Nitro 5 Tiger',
            'original_price' => 25000000,
            'discount_percent' => 10,
            'current_price' => 22500000,
            'image' => 'acer_nitro_5.jpg',
            'category_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('product_specs')->insert([
            ['product_id' => $msiMouseId, 'name' => 'Thương hiệu', 'value' => 'MSI', 'order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => $msiMouseId, 'name' => 'Độ nhạy', 'value' => '6200 DPI', 'order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => $msiMouseId, 'name' => 'Số nút bấm', 'value' => '8', 'order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => $msiMouseId, 'name' => 'Cảm Biến', 'value' => 'Avago 3327', 'order' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('product_specs')->insert([
            ['product_id' => $laptopId, 'name' => 'CPU', 'value' => 'Intel Core i5-12500H', 'order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => $laptopId, 'name' => 'RAM', 'value' => '16GB DDR4 3200MHz', 'order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => $laptopId, 'name' => 'VGA', 'value' => 'RTX 3050 4GB', 'order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => $laptopId, 'name' => 'Màn hình', 'value' => '15.6 inch FHD 144Hz', 'order' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}