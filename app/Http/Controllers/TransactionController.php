<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchasedProduct;
use App\Models\ShippingStatus;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function history()
    {
        $purchases = Purchase::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
        return view('pages.transactions', compact('purchases'));
    }

    public function show($id) 
    {
        $purchase = Purchase::find($id);
        $purchasedProducts = PurchasedProduct::find($id);
        $shippingStatus = ShippingStatus::all();
        return view('pages.transaction-details', compact('purchase', 'purchasedProducts','shippingStatus'));
    }

    public function transactionDetail() 
    {
        return view ('pages.transaction-details');
    }
}
