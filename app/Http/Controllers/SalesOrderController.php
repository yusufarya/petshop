<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use App\Models\SalesOrderDetail;
use Illuminate\Support\Facades\Auth;

class SalesOrderController extends Controller
{
    function index() {
        $filename = 'orders';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $data = SalesOrder::with('customers')->orderBy('code', 'DESC')->where(['status'=> 'N'])->get();
        // dd($data);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Order Pesanan',
            'auth_user' => $user,
            'resultData' => $data
        ]);
    }
    
    function detailOrder(Request $request, string $order_code) {

        $filename = 'order_detail';
        $filename_script = getContentScript(true, $filename);

        if($request->status) {
            SalesOrder::where('code', $order_code)->update(['status' => (string)$request->status]);
            OrderPayment::where('order_code', $order_code)->update(['status' => "Approve"]);
        }

        $user = Auth::guard('admin')->user();
        $resultDataHeader = SalesOrder::with('customers')->find($order_code);
        $resultDataDetail = SalesOrderDetail::with('products.sizes')->where(['sales_order_code' => $order_code])->get();
        
        $getPaymentOrder = OrderPayment::with('payment_methods')->where(['order_code' => $order_code])->first();
        // dd($resultDataDetail);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Detail Pesanan ',
            'auth_user' => $user,
            'dataHeader' => $resultDataHeader,
            'dataDetail' => $resultDataDetail,
            'orderPayment' => $getPaymentOrder,
        ]);
    }

    function productOrderDetails(Request $request, int $sequence) {
        $code = $request->order_code;

        $result = SalesOrderDetail::with('products.brands', 'products.sizes', 'products.categories')->where(['sales_order_code' => $code])->first();
        
        if($result) {
            return response()->json(['status' => 'success', 'result' => $result]);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }

    function salesOrder() {
        $filename = 'sales_order';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $data = SalesOrder::with('customers')
                            ->select('sales_orders.*', 'order_payments.status as status_payment')
                            ->leftJoin('order_payments', 'sales_orders.code', '=', 'order_payments.order_code')
                            ->orderBy('sales_orders.code', 'DESC')->where(['sales_orders.status'=> 'Y'])->get();
        // dd($data);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Order Penjualan ',
            'auth_user' => $user,
            'resultData' => $data
        ]);
    }

    public function updateStatusDelivery(Request $request)
    {
        $data = ['delivery' => $request->delivery];
        $result = SalesOrder::find($request->code)->update($data);
        if($result) {
            $request->session()->flash('success', 'Transaksi berhasil diperbaharui');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/sales-order');
    }

}