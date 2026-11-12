<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadProductImages extends Command
{
    protected $signature = 'products:download-images';
    protected $description = 'Download real product images from placeholder services';

    public function handle()
    {
        $products = [
            ['name' => 'tshirt-classic.jpg', 'query' => 't-shirt'],
            ['name' => 'hoodie-premium.jpg', 'query' => 'hoodie'],
            ['name' => 'polo-classic.jpg', 'query' => 'polo-shirt'],
            ['name' => 'tshirt-oversized.jpg', 'query' => 'oversized-tshirt'],
            ['name' => 'hoodie-zipup.jpg', 'query' => 'zip-hoodie'],
            ['name' => 'longsleeve-casual.jpg', 'query' => 'long-sleeve-shirt'],
            ['name' => 'crewneck-basic.jpg', 'query' => 'crewneck'],
            ['name' => 'cap-baseball.jpg', 'query' => 'baseball-cap'],
            ['name' => 'hat-bucket.jpg', 'query' => 'bucket-hat'],
            ['name' => 'tshirt-raglan.jpg', 'query' => 'raglan-shirt'],
            ['name' => 'tshirt-vneck.jpg', 'query' => 'v-neck-shirt'],
            ['name' => 'flannel-plaid.jpg', 'query' => 'flannel-shirt'],
            ['name' => 'jacket-bomber.jpg', 'query' => 'bomber-jacket'],
            ['name' => 'tanktop-basic.jpg', 'query' => 'tank-top'],
            ['name' => 'beanie-knit.jpg', 'query' => 'beanie-hat'],
        ];

        $path = public_path('images/products');
        
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        foreach ($products as $index => $product) {
            try {
                // Using Picsum Photos for random images with consistent seed
                $seed = 1000 + $index;
                $url = "https://picsum.photos/seed/{$seed}/800/800";
                
                $this->info("Downloading: {$product['name']}...");
                
                $response = Http::timeout(30)->get($url);
                
                if ($response->successful()) {
                    file_put_contents($path . '/' . $product['name'], $response->body());
                    $this->info("✓ Saved: {$product['name']}");
                } else {
                    $this->error("✗ Failed to download: {$product['name']}");
                }
                
                // Small delay to avoid rate limiting
                usleep(500000); // 0.5 seconds
                
            } catch (\Exception $e) {
                $this->error("✗ Error downloading {$product['name']}: " . $e->getMessage());
            }
        }

        $this->info('All product images downloaded successfully!');
    }
}
