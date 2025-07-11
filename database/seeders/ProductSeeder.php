<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Indomie Goreng',
                'description' => 'Mie instan goreng dengan bumbu khas',
                'price' => 3000,
                'stock' => 100,
                'barcode' => '1234567890123',
            ],
            [
                'name' => 'Teh Botol Sosro',
                'description' => 'Minuman teh kemasan botol',
                'price' => 5000,
                'stock' => 50,
                'barcode' => '1234567890124',
            ],
            [
                'name' => 'Coca Cola',
                'description' => 'Minuman bersoda Coca Cola',
                'price' => 7000,
                'stock' => 30,
                'barcode' => '1234567890125',
            ],
            [
                'name' => 'Biskuit Marie Regal',
                'description' => 'Biskuit manis dengan rasa susu',
                'price' => 4000,
                'stock' => 80,
                'barcode' => '1234567890126',
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
