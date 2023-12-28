<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SalesTransactionReport extends Controller
{
    function index() {
        $filename = 'sales_report';
        $filename_script = getContentScript(true, $filename);

        $admin = Auth::guard('admin')->user();
        
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Laporan Transaksi Penjualan',
            'auth_user' => $admin,
            'customers' => Customer::all(),
        ]);
    }

    function salesReport(Request $request) {
        // dd($request->customer);
        if($request->customer) {
            if($request->session()->get('customer') != $request->customer) {
                session()->forget('customer');
            }
            $request->session()->push('customer', $request->customer);
        } else {
            session()->forget('customer');
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

    function openSalesReport(Request $request) {
        $where = ['sales_orders.status'=>'Y'];
        
        if($request->session()->get('customer')) {
            $where = ['sales_orders.customer_code' => $request->session()->get('customer')];
        }

        if($request->session()->get('date') OR $request->session()->get('date1')) {
            $date = $request->session()->get('date');
            $date1 = $request->session()->get('date1');
            // dd($date);
            // dd($date1);
        } 

        if ($where) {
            $data = DB::table('sales_order_details')
                ->select('sales_order_details.*','customers.fullname as customer_name', 'sales_orders.qty as total_qty', 'sales_orders.total_price as total_price', 
                'products.name as product_name')
                ->leftJoin('sales_orders', 'sales_orders.code', '=', 'sales_order_details.sales_order_code')
                ->leftJoin('customers', 'sales_orders.customer_code', '=', 'customers.code')
                ->leftJoin('products', 'sales_order_details.product_id', '=', 'products.id') 
                ->where($where) 
                ->WhereBetween('sales_orders.date', [$date, $date1])
                ->get();
                
        } else {

            $data = DB::table('sales_order_details')
                ->select('sales_order_details.*','customers.fullname as customer_name', 'sales_orders.qty as total_qty', 'sales_orders.total_price as total_price', 
                'products.name as product_name')
                ->leftJoin('sales_orders', 'sales_orders.code', '=', 'sales_order_details.sales_order_code')
                ->leftJoin('customers', 'sales_orders.customer_code', '=', 'customers.code')
                ->leftJoin('products', 'sales_order_details.product_id', '=', 'products.id')
                ->whereBetween('sales_orders.date', [$date, $date1])
                ->get();
        }

        // dd($data);
        return view('admin-page.report.sales_rpt', [
            'title' => 'Laporan Transaksi Penjualan',
            'data' => $data,
        ]);
    }
}
