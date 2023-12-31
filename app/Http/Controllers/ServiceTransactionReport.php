<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServiceTransactionReport extends Controller
{
    function index() {
        $filename = 'service_report';
        $filename_script = getContentScript(true, $filename);

        $admin = Auth::guard('admin')->user();
        
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Laporan Transaksi Layanan',
            'auth_user' => $admin,
            'customers' => Customer::all(),
        ]);
    }

    function serviceReport(Request $request) {
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

    function openServiceReport(Request $request) {
        $where = ['service_orders.status'=>'Y'];
        
        if($request->session()->get('customer')) {
            $where = ['service_orders.customer_code' => $request->session()->get('customer')];
        }

        if($request->session()->get('date') OR $request->session()->get('date1')) {
            $date = $request->session()->get('date');
            $date1 = $request->session()->get('date1');
            // dd($date);
            // dd($date1);
        } 

        if ($where) {
            $data = DB::table('service_orders')
                ->select('service_orders.*','customers.fullname as customer_name', 'service_orders.price as total_price')
                ->leftJoin('customers', 'service_orders.customer_code', '=', 'customers.code')
                ->where($where) 
                ->orWhereBetween('service_orders.start_date', [$date, $date1])
                ->orWhereBetween('service_orders.end_date', [$date, $date1])
                ->get();
                
        } else {

            $data = DB::table('service_orders')
                ->select('service_orders.*','customers.fullname as customer_name', 'service_orders.price as total_price')
                ->leftJoin('customers', 'service_orders.customer_code', '=', 'customers.code')
                ->orWhereBetween('service_orders.start_date', [$date, $date1])
                ->orWhereBetween('service_orders.end_date', [$date, $date1])
                ->get();
        }

        // dd($data);
        return view('admin-page.report.service_rpt', [
            'title' => 'Laporan Transaksi Pelayanan',
            'data' => $data,
        ]);
    }
}
