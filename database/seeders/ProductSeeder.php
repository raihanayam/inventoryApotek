<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            "name" => "Mixagrip Flu & Batuk",
            "sku" => "T001",
            "price" => 4000,
            "stock" => 100,
            "category_id" => 1,
            "expired_at" => "2026-12-31",
        ]);
    }
}
