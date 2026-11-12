<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class ProcessPendingCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Process pending cart after login/register
        if (Auth::check() && session()->has('cart_data')) {
            $cartData = session('cart_data');
            
            // Create cart entry from session data
            $existingCart = Cart::where('user_id', Auth::id())
                                ->where('product_id', $cartData['product_id'])
                                ->first();
            
            if ($existingCart) {
                // Update existing cart
                $existingCart->amount += $cartData['amount'];
                $existingCart->link_design = $cartData['link_design'];
                $existingCart->update();
            } else {
                // Create new cart entry
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $cartData['product_id'],
                    'amount' => $cartData['amount'],
                    'link_design' => $cartData['link_design'],
                    'size_id' => $cartData['size_id'],
                    'color_id' => $cartData['color_id'],
                    'printing_id' => $cartData['printing_id'],
                    'notes' => $cartData['notes']
                ]);
            }
            
            // Clear session data
            session()->forget('cart_data');
            
            // Show success message
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Item berhasil ditambahkan ke keranjang'
            ]);
        }
        
        return $next($request);
    }
}
