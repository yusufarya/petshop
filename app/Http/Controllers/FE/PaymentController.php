<?php

namespace App\Http\Controllers\FE;

use App\Models\Customer;
use App\Models\SalesOrder;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\SalesOrderDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    function index(string $code_tr, string $from_page = null) {
        // dd($from_page);
        $filename = 'payment';
        $filename_script = getContentScript(false, $filename);

        $code = Auth::guard('customer')->user()->code;
        $data = Customer::find($code);
        
        $result = SalesOrder::with('salesOrderDetails.products.categories', 'salesOrderDetails.products.sizes', 'salesOrderDetails.products.brands')
                ->find($code_tr);
        $resultDetail = SalesOrderDetail::with('sales_order', 'products.categories', 'products.sizes', 'products.brands')
                                          ->where('sales_order_code', $code_tr)->get();
        
        $checkOrderPayment = OrderPayment::where(['order_code' => $code_tr])->first();
        
        if($checkOrderPayment) {
            $where = ['sales_order_code' => $code_tr];
        
            $qty = SalesOrderDetail::where($where)->sum('qty');
            $total_price = SalesOrderDetail::where($where)
                                            ->sum(DB::raw('price * qty'));

            $dataHeader = [
                'qty' => $qty,
                'total_price' => $total_price,
            ];
            // dd($dataHeader);
            $update = SalesOrder::where(['code' => $code_tr])->update($dataHeader);
            return redirect('/pay-order/'.$code_tr);
            
        }

        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Detail Pesanan Saya',
            'auth_user' => $data,
            'resultData' => $result,
            'resultDataDetail' => $resultDetail,
            'pageCart' => $from_page ? true : false
        ]);
    }

    function prosesPayOrder(Request $request) {
        $sales_order_code = $request->code;
        $pageCart = $request->pageCart;
        
        if($pageCart != "false") {
            // dd(1);
            $orderHD = [
                'charge' => cleanSpecialChar($request->charge),
                'nett' => cleanSpecialChar($request->netto)
            ];
            $orderDT = [
                'charge' => $request->charge
            ];
        } else {
            // dd(2);
            $orderHD = [
                'qty' => $request->qty_dt,
                'total_price' => cleanSpecialChar($request->total_price),
                'charge' => cleanSpecialChar($request->charge),
                'nett' => cleanSpecialChar($request->netto)
            ];
            $orderDT = [
                'qty' => $request->qty_dt,
                'price' => $request->price,
                'charge' => $request->charge
            ];
        }

        $code_pelanggan = Auth::guard('customer')->user()->code;

        SalesOrder::where(['customer_code' => $code_pelanggan, 'code' => $sales_order_code])->update($orderHD);
        SalesOrderDetail::where(['sales_order_code' => $sales_order_code])->update($orderDT);
        
        $order_result = SalesOrder::with('salesOrderDetails.products.categories', 'salesOrderDetails.products.sizes', 'salesOrderDetails.products.brands')
                ->find($sales_order_code);
        // dd($order_result);
        $order_payment_code = getLastPayCode();

        $dataInsert = [
            'code' => $order_payment_code,
            'order_code' => $sales_order_code,
            'date' => date('Y-m-d h:i:s')
        ];

        $checkOrderPayment = OrderPayment::where(['order_code' => $sales_order_code])->first();

        if($checkOrderPayment) {
            $result = OrderPayment::where(['order_code' => $sales_order_code])->update(['date' => date('Y-m-d h:i:s')]);
        } else {
            $result = OrderPayment::create($dataInsert);
        }

        if($result) {
            return response()->json(['status' => 'success', 'resultData' => $order_result]);
        } else {
            return response()->json(['status' => 'failed']);
        }
        
    }

    function payOrder(string $sales_order_code) {
        
        if($sales_order_code) {
            $filename = 'pay_order';
            $filename_script = getContentScript(false, $filename);
    
            $user = Auth::guard('customer')->user();
            
            $payment_method = PaymentMethod::get();  
            
            $result = SalesOrder::with('salesOrderDetails.products.categories', 'salesOrderDetails.products.sizes', 'salesOrderDetails.products.brands')
                    ->find($sales_order_code);
            
            if(!$result) {
                return redirect('/');    
            }
            
            if(ucwords(trim($user->city)) == 'Jakarta') {
                $deliveryId = 1;
            } else {
                $deliveryId = 2;
            }
            $charge = getCharge($deliveryId)->charge;
            
            $where = ['sales_order_code' => $sales_order_code];
        
            $qty = SalesOrderDetail::where($where)->sum('qty');
            $total_price = SalesOrderDetail::where($where)
                                            ->sum(DB::raw('price * qty'));
            $nett = SalesOrderDetail::where($where)
                                            ->sum(DB::raw('(price * qty)+charge'));
            
            $dataHeader = [
                'qty' => $qty,
                'charge' => $charge,
                'total_price' => $total_price,
                'nett' => $nett,
            ];
            // dd($dataHeader);
            $update = SalesOrder::where(['code' => $sales_order_code])->update($dataHeader);

            $checkOrderPayment = OrderPayment::where(['order_code' => $sales_order_code])->first();
    
            // dd($result);
            return view('user-page.'.$filename, [
                'script' => $filename_script,
                'title' => 'Pembayaran',
                'auth_user' => $user,
                'resultData' => $result,
                'payment_method' => $payment_method,
                'payment_id' => $checkOrderPayment ? $checkOrderPayment->payment_method_id : ''
            ]);
        } else {
            return redirect('/');
        }

    }

    function updatePaymentMethod(Request $request) {
        $result = OrderPayment::where(['order_code' => $request->order_code])->update(['payment_method_id' => $request->payment_method]);
        return response()->json(['result' => $result]);
    }

    function uploadImgPayment(Request $request) {
        // dd($request);
        $order_code = $request->order_code;
        $image = $request->file('images')->store('payment-upload');

        $data = ['image' => $image];

        $updated = OrderPayment::where(['order_code' => $order_code])->update($data);

        if($updated) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'failed']);
        }

    }

    function cancelOrders(Request $request) {
        // dd($request->code);
        $salesDetail = SalesOrderDetail::where(['sales_order_code' => $request->code])->delete();
        $sales = SalesOrder::where(['code' => $request->code])->delete();
        $salesDetail = OrderPayment::where(['order_code' => $request->code])->delete();
        
        return true;
    }

}
