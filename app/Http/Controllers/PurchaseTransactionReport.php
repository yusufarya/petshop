<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseTransactionReport extends Controller
{
    function index() {
        $filename = 'purchase_report';
        $filename_script = getContentScript(true, $filename);

        $admin = Auth::guard('admin')->user();
        
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Laporan Transaksi Pembelian',
            'auth_user' => $admin,
            'vendors' => Vendor::all(),
        ]);
    }

    function purchaseReport(Request $request) {
        // dd($request->vendor);
        if($request->vendor) {
            if($request->session()->get('vendor') != $request->vendor) {
                session()->forget('vendor');
            }
            $request->session()->push('vendor', $request->vendor);
        } else {
            session()->forget('vendor');
        }
        
        if($request->date) {
            if($request->session()->get('date') != $request->date) {
                session()->forget('date');
            }
            $request->session()->push('date', $request->date);
        } else {
            session()->forget('date');
        }
        
        if($request->date1) {
            if($request->session()->get('date1') != $request->date1) {
                session()->forget('date1');
            }
            $request->session()->push('date1', $request->date1);
        } else {
            session()->forget('date1');
        }
        
        echo json_encode('{}');
    }

    function openPurchaseReport(Request $request) {
        $where = '';
        
        if($request->session()->get('vendor')) {
            $where = ['purchase_orders.vendor_code' => $request->session()->get('vendor')];
        }

        if($request->session()->get('date') OR $request->session()->get('date1')) {
            $date = $request->session()->get('date');
            $date1 = $request->session()->get('date1');
            // dd($date);
            // dd($date1);
        } 

        if ($where) {
            $data = DB::table('purchase_order_details')
                ->select('purchase_order_details.*','vendors.name as vendor_name', 'purchase_orders.qty as total_qty', 'purchase_orders.total_price as total_price', 
                'products.name as product_name')
                ->leftJoin('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_details.purchase_order_id')
                ->leftJoin('vendors', 'purchase_orders.vendor_code', '=', 'vendors.code')
                ->leftJoin('products', 'purchase_order_details.product_id', '=', 'products.id') 
                ->where($where) 
                ->WhereBetween('purchase_orders.date', [$date, $date1])
                ->get();
                
        } else {

            $data = DB::table('purchase_order_details')
                ->select('purchase_order_details.*','vendors.name as vendor_name', 'purchase_orders.qty as total_qty', 'purchase_orders.total_price as total_price', 
                'products.name as product_name')
                ->leftJoin('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_details.purchase_order_id')
                ->leftJoin('vendors', 'purchase_orders.vendor_code', '=', 'vendors.code')
                ->leftJoin('products', 'purchase_order_details.product_id', '=', 'products.id')
                ->whereBetween('purchase_orders.date', [$date, $date1])
                ->get();
        }

        // dd($data);
        return view('admin-page.report.purchase_rpt', [
            'title' => 'Laporan Transaksi Pembelian',
            'data' => $data,
        ]);
    }
}
