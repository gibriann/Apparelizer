<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Purchase;
use App\Models\PaymentStatus;
use App\Models\ShippingStatus;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $purchases = Purchase::where('payment_status_id', '!=' ,3)->orderBy('id', 'desc')->get();
        $paymentStatuses = PaymentStatus::all();
        $shippingStatuses = ShippingStatus::all();
        return view('pages.admin-new.dashboard-transactions', compact('purchases', 'paymentStatuses', 'shippingStatuses'));
    }

    public function show($id) 
    {
        $purchase = Purchase::find($id);
        $shippingStatus = ShippingStatus::all();
        return view('pages.admin-new.dashboard-transactions-detail', compact('purchase', 'shippingStatus'));
    }

    public function update(Request $request, $id) 
    {
        $rules = [
            'shipping_status_id' => 'required',
        ];

        $customMessage = [
            'required' => 'Silahkan Masukan :attribute',
        ];

        $this->validate($request, $rules, $customMessage);

        Purchase::where('id',$id)->update([
            'shipping_status_id' => $request->shipping_status_id
        ]);
        
        Alert::toast('Data berhasil diubah','success');
        return redirect(route('dashboard-transactions'));
        // return $request;    
    }

    public function resi(Request $request, $id) 
    {
        $rules = [
            'resi' => 'required',
        ];

        $customMessage = [
            'required' => 'Silahkan Masukan :attribute',
        ];

        $this->validate($request, $rules, $customMessage);

        Purchase::where('id',$id)->update([
            'shipment_receipt' => $request->resi
        ]);
        
        Alert::toast('Data berhasil diubah','success');
        return redirect(route('dashboard-transactions'));
        // return $request;    
    }

    public function detailCustomer($id)
    {
        $purchase = Purchase::find($id);
        $pdf = PDF::loadView('pages.admin-new.reports.detailcustomer', compact('purchase'));
        $pdf->setPaper(array(0,0,567.00,283.80));
        return $pdf->stream("Customer_".$purchase->recipient."_".$purchase->code.".pdf");
    }
}
