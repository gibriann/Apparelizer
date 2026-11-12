<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()) {
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
                return redirect('dashboard');
            }
        }
        $products = Product::all();
        return view('pages.home', compact('products'));
    }
}
