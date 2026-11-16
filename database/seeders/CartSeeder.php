<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Color;
use App\Models\PrintingType;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Isi keranjang kalau masih kosong, buat demo checkout.
     */
    public function run()
    {
        $customer = User::where('role_id', 3)->first();
        $product = Product::first();

        if (!$customer || !$product) {
            return;
        }

        if (Cart::where('user_id', $customer->id)->exists()) {
            return;
        }

        $size = Size::first();
        $color = Color::first();
        $printing = PrintingType::first();

        if (!$size || !$color || !$printing) {
            return;
        }

        Cart::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'amount' => 2,
            'size_id' => $size->id,
            'color_id' => $color->id,
            'printing_id' => $printing->id,
            'link_design' => 'https://drive.google.com/file/d/dummy-design/view',
        ]);
    }
}
