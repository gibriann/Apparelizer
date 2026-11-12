<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateProductImages extends Command
{
    protected $signature = 'products:generate-images';
    protected $description = 'Generate placeholder images for products';

    public function handle()
    {
        $products = [
            ['name' => 'tshirt-classic.jpg', 'rgb' => [59, 130, 246], 'text' => 'T-SHIRT'],
            ['name' => 'hoodie-premium.jpg', 'rgb' => [139, 92, 246], 'text' => 'HOODIE'],
            ['name' => 'polo-classic.jpg', 'rgb' => [16, 185, 129], 'text' => 'POLO'],
            ['name' => 'tshirt-oversized.jpg', 'rgb' => [245, 158, 11], 'text' => 'OVERSIZED'],
            ['name' => 'hoodie-zipup.jpg', 'rgb' => [239, 68, 68], 'text' => 'ZIP HOODIE'],
            ['name' => 'longsleeve-casual.jpg', 'rgb' => [99, 102, 241], 'text' => 'LONG SLEEVE'],
            ['name' => 'crewneck-basic.jpg', 'rgb' => [236, 72, 153], 'text' => 'CREWNECK'],
            ['name' => 'cap-baseball.jpg', 'rgb' => [20, 184, 166], 'text' => 'CAP'],
            ['name' => 'hat-bucket.jpg', 'rgb' => [249, 115, 22], 'text' => 'BUCKET HAT'],
            ['name' => 'tshirt-raglan.jpg', 'rgb' => [6, 182, 212], 'text' => 'RAGLAN'],
            ['name' => 'tshirt-vneck.jpg', 'rgb' => [139, 92, 246], 'text' => 'V-NECK'],
            ['name' => 'flannel-plaid.jpg', 'rgb' => [220, 38, 38], 'text' => 'FLANNEL'],
            ['name' => 'jacket-bomber.jpg', 'rgb' => [5, 150, 105], 'text' => 'BOMBER'],
            ['name' => 'tanktop-basic.jpg', 'rgb' => [124, 58, 237], 'text' => 'TANK TOP'],
            ['name' => 'beanie-knit.jpg', 'rgb' => [234, 88, 12], 'text' => 'BEANIE'],
        ];

        $path = public_path('images/products');
        
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        foreach ($products as $product) {
            $image = imagecreatetruecolor(800, 800);
            
            // Background color
            $bgColor = imagecolorallocate($image, $product['rgb'][0], $product['rgb'][1], $product['rgb'][2]);
            imagefill($image, 0, 0, $bgColor);
            
            // White text color
            $textColor = imagecolorallocate($image, 255, 255, 255);
            
            // Add text using built-in font
            $text = $product['text'];
            $fontSize = 5; // Built-in font size (1-5)
            
            // Calculate position for centered text
            $textWidth = imagefontwidth($fontSize) * strlen($text);
            $textHeight = imagefontheight($fontSize);
            $x = (800 - $textWidth) / 2;
            $y = (800 - $textHeight) / 2;
            
            imagestring($image, $fontSize, $x, $y, $text, $textColor);
            
            // Save image
            imagejpeg($image, $path . '/' . $product['name'], 90);
            imagedestroy($image);
            
            $this->info("Generated: {$product['name']}");
        }

        $this->info('All product images generated successfully!');
    }
}
