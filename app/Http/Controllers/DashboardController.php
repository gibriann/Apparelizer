<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchasedProduct;
use App\Models\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\String\b;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = User::where('role_id', 3)->count();
        $purchaseCount = Purchase::count();
        $totalPayment = Purchase::where('payment_status_id', 2)->sum('total_payment');
        $shipmentFee = Purchase::where('payment_status_id', 2)->sum('shipment_fee');
        $totalIncome = $totalPayment - $shipmentFee;
        $purchases = Purchase::take(5)->orderBy('id','desc')->get();
        return view('pages.admin-new.dashboard', compact('customer', 'purchaseCount','totalIncome', 'purchases'));
    }

    public function report(){
        
        return view('pages.admin-new.dashboard-report');
    }

    public function date(Request $request)
    {
        $rules = [
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required',
        ];
        
        $customMessage = [
            'required' => 'Silahkan Masukan :attribute',
        ];
        
        $attributeName = [
            'tgl_awal' => 'Tanggal Awal',
            'tgl_akhir' => 'Tanggal Akhir',
        ];

        $this->validate($request, $rules, $customMessage, $attributeName);

        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $a = Carbon::parse($tgl_awal)->startOfDay()->toDateTimeString();
        $b = Carbon::parse($tgl_akhir)->endOfDay()->toDateTimeString();
        $formatedMasuk = Carbon::parse($tgl_awal)->format('d/m/Y');
        $formatedAkhir = Carbon::parse($tgl_akhir)->format('d/m/Y');
        $purchases = PurchasedProduct::whereHas('purchase', function($q) use ($a, $b){
            $q->where('payment_status_id', 2)->whereBetween('created_at', [$a, $b]);
        })->select('product_id','size_id','color_id','printing_id', DB::raw('sum(quantity) as quantity'), DB::raw('sum(total_order) as total_order'))->groupBy('product_id','size_id','color_id','printing_id')->get();
        $pdf = PDF::loadView('pages.admin-new.reports.datepdf', compact('purchases','tgl_awal','tgl_akhir'));
        $pdf->setPaper('A4');
        return $pdf->stream("laporan ".$formatedMasuk." - ".$formatedAkhir.".pdf");
    }

    public function periode(Request $request)
    {
        $filter = $request->periode;
        if($filter == "hari ini"){
            $periode = Carbon::now()->translatedFormat('Y-m-d');
            $formatedNow = Carbon::now()->format('d F Y');
            $dayStart = Carbon::now()->startOfDay()->toDateTimeString();
            $dayEnd = Carbon::now()->endOfDay()->toDateTimeString();
            $purchases = PurchasedProduct::whereHas('purchase', function($q) use($dayStart, $dayEnd){
                $q->where('payment_status_id', 2)->whereBetween('created_at', [$dayStart, $dayEnd]);
            })->select('product_id','size_id','color_id','printing_id', DB::raw('sum(quantity) as quantity'), DB::raw('sum(total_order) as total_order'))->groupBy('product_id','size_id','color_id','printing_id')->get();
            $pdf = PDF::loadView('pages.admin-new.reports.periodepdf', compact('purchases','periode','filter'));
            $pdf->setPaper('A4');
            return $pdf->stream("laporan harian -".$formatedNow.".pdf");
        }elseif($filter == "minggu ini"){
            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->translatedFormat('d F Y');
            $weekEndDate = $now->endOfWeek()->translatedFormat('d F Y');
            $periode = $weekStartDate."-".$weekEndDate;
            $purchases = PurchasedProduct::whereHas('purchase', function($q){
                $q->where('payment_status_id', 2)->whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            })->select('product_id','size_id','color_id','printing_id', DB::raw('sum(quantity) as quantity'), DB::raw('sum(total_order) as total_order'))->groupBy('product_id','size_id','color_id','printing_id')->get();
            $pdf = PDF::loadView('pages.admin-new.reports.periodepdf', compact('purchases','periode','filter'));
            $pdf->setPaper('A4');
            return $pdf->stream("laporan mingguan -".$periode.".pdf");
        }elseif($filter == "bulan ini"){
            $periode = Carbon::now()->translatedFormat('F Y');
            $bulan = Carbon::now()->format('m');
            $tahun = Carbon::now()->format('Y');
            $purchases = PurchasedProduct::whereHas('purchase', function($q) use($bulan, $tahun){
                $q->where('payment_status_id', 2)->whereMonth('created_at',$bulan)->whereYear('created_at', $tahun);
            })->select('product_id','size_id','color_id','printing_id', DB::raw('sum(quantity) as quantity'), DB::raw('sum(total_order) as total_order'))->groupBy('product_id','size_id','color_id','printing_id')->get();
            $pdf = PDF::loadView('pages.admin-new.reports.periodepdf', compact('purchases','periode','filter'));
            $pdf->setPaper('A4');
            return $pdf->stream("laporan bulanan - ".$periode.".pdf");
        }elseif($filter == "tahun ini"){
            $periode = Carbon::now()->translatedFormat('Y');
            $tahun = Carbon::now()->format('Y');
            $purchases = PurchasedProduct::whereHas('purchase', function($q) use($tahun){
                $q->where('payment_status_id', 2)->whereYear('created_at', $tahun);
            })->select('product_id','size_id','color_id','printing_id', DB::raw('sum(quantity) as quantity'), DB::raw('sum(total_order) as total_order'))->groupBy('product_id','size_id','color_id','printing_id')->get();
            $pdf = PDF::loadView('pages.admin-new.reports.periodepdf', compact('purchases','periode','filter'));
            $pdf->setPaper('A4');
            return $pdf->stream("laporan tahunan - ".$periode.".pdf");
        }
    }
}
