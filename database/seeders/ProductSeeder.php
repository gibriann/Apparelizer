<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'product_name' => 'Classic Cotton T-Shirt',
                'slug' => 'classic-cotton-tshirt',
                'product_price' => 85000,
                'product_weight' => 200,
                'product_description' => 'Kaos cotton combed 30s premium, nyaman dipakai sehari-hari. Tersedia berbagai warna dan ukuran.',
                'product_image' => 'products/tshirt-classic.jpg',
            ],
            [
                'product_name' => 'Premium Hoodie',
                'slug' => 'premium-hoodie',
                'product_price' => 185000,
                'product_weight' => 500,
                'product_description' => 'Hoodie fleece premium dengan kualitas jahitan rapi. Cocok untuk cuaca dingin dan santai.',
                'product_image' => 'products/hoodie-premium.jpg',
            ],
            [
                'product_name' => 'Polo Shirt Classic',
                'slug' => 'polo-shirt-classic',
                'product_price' => 120000,
                'product_weight' => 250,
                'product_description' => 'Polo shirt cotton pique yang elegan, cocok untuk acara formal maupun casual.',
                'product_image' => 'products/polo-classic.jpg',
            ],
            [
                'product_name' => 'Oversized T-Shirt',
                'slug' => 'oversized-tshirt',
                'product_price' => 95000,
                'product_weight' => 230,
                'product_description' => 'T-shirt oversized trendy dengan bahan cotton 24s yang adem dan nyaman.',
                'product_image' => 'products/tshirt-oversized.jpg',
            ],
            [
                'product_name' => 'Zip-Up Hoodie',
                'slug' => 'zipup-hoodie',
                'product_price' => 195000,
                'product_weight' => 550,
                'product_description' => 'Hoodie zipper premium dengan detail rapi. Praktis dan stylish untuk aktivitas outdoor.',
                'product_image' => 'products/hoodie-zipup.jpg',
            ],
            [
                'product_name' => 'Long Sleeve Shirt',
                'slug' => 'long-sleeve-shirt',
                'product_price' => 145000,
                'product_weight' => 300,
                'product_description' => 'Kemeja lengan panjang casual dengan bahan cotton twill yang breathable.',
                'product_image' => 'products/longsleeve-casual.jpg',
            ],
            [
                'product_name' => 'Crewneck Sweatshirt',
                'slug' => 'crewneck-sweatshirt',
                'product_price' => 165000,
                'product_weight' => 450,
                'product_description' => 'Crewneck fleece premium tanpa hoodie, simpel dan nyaman untuk daily wear.',
                'product_image' => 'products/crewneck-basic.jpg',
            ],
            [
                'product_name' => 'Baseball Cap',
                'slug' => 'baseball-cap',
                'product_price' => 65000,
                'product_weight' => 100,
                'product_description' => 'Topi baseball adjustable dengan bahan cotton drill berkualitas.',
                'product_image' => 'products/cap-baseball.jpg',
            ],
            [
                'product_name' => 'Bucket Hat',
                'slug' => 'bucket-hat',
                'product_price' => 75000,
                'product_weight' => 120,
                'product_description' => 'Bucket hat trendy dengan bahan cotton canvas, cocok untuk gaya kasual.',
                'product_image' => 'products/hat-bucket.jpg',
            ],
            [
                'product_name' => 'Raglan T-Shirt',
                'slug' => 'raglan-tshirt',
                'product_price' => 90000,
                'product_weight' => 210,
                'product_description' => 'Kaos raglan dengan kombinasi warna di lengan, desain sporty dan casual.',
                'product_image' => 'products/tshirt-raglan.jpg',
            ],
            [
                'product_name' => 'V-Neck T-Shirt',
                'slug' => 'vneck-tshirt',
                'product_price' => 88000,
                'product_weight' => 200,
                'product_description' => 'Kaos v-neck premium dengan cutting yang pas di badan.',
                'product_image' => 'products/tshirt-vneck.jpg',
            ],
            [
                'product_name' => 'Flannel Shirt',
                'slug' => 'flannel-shirt',
                'product_price' => 155000,
                'product_weight' => 350,
                'product_description' => 'Kemeja flanel dengan motif kotak-kotak, hangat dan stylish.',
                'product_image' => 'products/flannel-plaid.jpg',
            ],
            [
                'product_name' => 'Bomber Jacket',
                'slug' => 'bomber-jacket',
                'product_price' => 225000,
                'product_weight' => 600,
                'product_description' => 'Jaket bomber dengan bahan parasut berkualitas, waterproof dan ringan.',
                'product_image' => 'products/jacket-bomber.jpg',
            ],
            [
                'product_name' => 'Tank Top',
                'slug' => 'tank-top',
                'product_price' => 65000,
                'product_weight' => 150,
                'product_description' => 'Tank top cotton untuk olahraga atau santai, adem dan menyerap keringat.',
                'product_image' => 'products/tanktop-basic.jpg',
            ],
            [
                'product_name' => 'Beanie Hat',
                'slug' => 'beanie-hat',
                'product_price' => 55000,
                'product_weight' => 80,
                'product_description' => 'Kupluk beanie rajut yang hangat dan trendy untuk cuaca dingin.',
                'product_image' => 'products/beanie-knit.jpg',
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'product_name' => $product['product_name'],
                'slug' => $product['slug'],
                'product_price' => $product['product_price'],
                'product_weight' => $product['product_weight'],
                'product_description' => $product['product_description'],
                'product_image' => $product['product_image'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
