<?php

namespace App\Http\Controllers;

use App\Models\OrderPayment;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceOrdersController extends Controller
{
    function index() {
        $filename = 'service_order';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $data = ServiceOrder::with('customers')->orderBy('code', 'DESC')->get();
        // dd($data);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Order Layanan',
            'auth_user' => $user,
            'resultData' => $data
        ]);
    }

    function detailRequest(Request $request, string $order_code) {
        // dd($order_code);
        $filename = 'service_order_detail';
        $filename_script = getContentScript(true, $filename);

        if($request->status) {
            ServiceOrder::with('sizes')->where('code', $order_code)->update(['status' => (string)$request->status]);
            OrderPayment::where('order_code', $order_code)->update(['status' => "Approve"]);
        }

        $user = Auth::guard('admin')->user();
        $resultDataHeader = ServiceOrder::with('customers')->find($order_code);
        
        $getPaymentOrder = OrderPayment::with('payment_methods')->where(['order_code' => $order_code])->first();
        // dd($getPaymentOrder);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Detail Order Layanan ',
            'auth_user' => $user,
            'resultData' => $resultDataHeader,
            'orderPayment' => $getPaymentOrder,
        ]);
    }

    function updatePriceRequest(Request $request, string $order_code) {
        $data = ['price' => cleanSpecialChar($request->price)];
        $result = ServiceOrder::find($request->code)->update($data);
        if($result) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }

    function accPaymentRequest(Request $request, string $order_code) {
        $data = ['status' => 'Y'];
        $result = ServiceOrder::find($request->code)->update($data);
        $data2 = ['status' => 'Approve'];
        $result = OrderPayment::where('order_code',$request->code)->update($data2);
        if($result) {
            return redirect('/service-order/'.$order_code.'/detail');
        } else {
            return response()->json(['status' => 'failed']);
        }
    }

    public function updateStatusDelivery(Request $request) {

        $data = ['delivery' => $request->delivery];
        $result = ServiceOrder::find($request->code)->update($data);
        if($result) {
            $request->session()->flash('success', 'Transaksi berhasil diperbaharui');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/service-order');
    }
}
