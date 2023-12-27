<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryTransactionController extends Controller
{
    function index() {
        $filename = 'deliveries';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $data1 = SalesOrder::with('customers')
                            ->select('sales_orders.*', 'order_payments.status as status_payment')
                            ->leftJoin('order_payments', 'sales_orders.code', '=', 'order_payments.order_code')
                            ->orderBy('sales_orders.code', 'DESC')->where(['sales_orders.status'=> 'Y'])->get();
        // $data2 = ServiceOrder::with('customers', 'sizes')->get();
        // dd($data);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Pengiriman Pesanan ',
            'auth_user' => $user,
            'resultData1' => $data1,
            // 'resultData2' => $data2
            'resultData2' => []
        ]);
    }

    public function updateStatusDelivery(Request $request)
    {
        $data = ['delivery' => $request->delivery];
        
        $code = substr($request->code, 0,2);
        if($code == 'ST') {
            $result = SalesOrder::find($request->code)->update($data);
        } else if($code == 'CR') {
            $result = ServiceOrder::find($request->code)->update($data);
        }
        if($result) {
            $request->session()->flash('success', 'Transaksi berhasil diperbaharui');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/delivery');
    }
}
