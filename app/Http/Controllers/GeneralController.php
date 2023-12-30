<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Models\Customer;
use App\Models\SalesOrder;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Models\SalesOrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller {
    
    function checkDataUser(Request $request,int $productId) {
        $user = Auth::guard('customer')->user();
        // dd($productId);
        if($user->place_of_birth == null OR
            $user->date_of_birth == null OR 
            $user->phone == null OR 
            $user->address == null
        ) {
            $request->session()->flash('message', 'Anda belum bisa melakukan pembelian, lengkapi data untuk melanjutkan.');
            return redirect('/detail-product/'.$productId);
        } else {

            $productData = Product::with('inventory')->where(['id' => $productId])->first();
            $stock =  $productData->inventory ? $productData->inventory->stock : 0;

            if($stock <= 0) {
                $request->session()->flash('message', 'Produk yang anda pilih telah habis.');
                return redirect('/detail-product/'.$productId);
            }

            $checkOrderHeader = SalesOrder::with('salesOrderDetails.products')
                                ->where(['customer_code' => $user->code])
                                ->first();
            
            if($checkOrderHeader) {
                if($checkOrderHeader->status == 'N') {
                    if($checkOrderHeader->salesOrderDetails != NULL) {
                        if($productId == $checkOrderHeader->salesOrderDetails->products->id) {
                            $request->session()->flash('message', 'Anda mempunyai pesanan pada produk yang sama, <a href="/payment/'.$checkOrderHeader->code.'">lihat pesanan</a>.');
                            return redirect('/detail-product/'.$productId);
                        }
                    }
                }
            }

            // exit;

            $dataHeader = [
                'customer_code' => $user->code,
                'date' => date('Y-m-d'),
            ];

            if($checkOrderHeader) {
                if($checkOrderHeader->status == 'Y') {
                    $code = getLasCodeTransaction('S');
        
                    $dataHeader['code'] = $code;
                    SalesOrder::create($dataHeader);
                } else {
                    $code = $checkOrderHeader->code;
                }
            } else {
                $code = getLasCodeTransaction('S');
    
                $dataHeader['code'] = $code;
                SalesOrder::create($dataHeader);
            }

            $dataDetail = [
                'sequence' => 1,
                'sales_order_code' => $code,
                'product_id' => $productId,
                'date' => date('Y-m-d'),
            ];

            SalesOrderDetail::create($dataDetail);

            return redirect('/payment/'.$code);
            
        }
        
    }
    
    function checkDataUserService(Request $request, int $serviceId) {
        $user = Auth::guard('customer')->user();
        // dd($serviceId);
        if($user->place_of_birth == null OR
            $user->date_of_birth == null OR 
            $user->phone == null OR 
            $user->address == null
        ) {
            $request->session()->flash('message', 'Anda belum bisa melakukan pemesanan, lengkapi data untuk melanjutkan.');
            return redirect('/detail-services/'.$serviceId);
        } else {

            $productData = Service::with('categories')->where(['id' => $serviceId])->first();
            // $stock =  $productData->inventory ? $productData->inventory->stock : 0;

            // if($stock <= 0) {
            //     $request->session()->flash('message', 'Layanan yang anda pilih telah habis.');
            //     return redirect('/detail-services/'.$serviceId);
            // }

            $checServiceskOrder = ServiceOrder::with('categories')
                                ->where(['customer_code' => $user->code])
                                ->first();
            // dd($checServiceskOrder);
            if($checServiceskOrder) {
                if($checServiceskOrder->status == 'N') {
                
                    if($serviceId == $checServiceskOrder->id) {
                        $request->session()->flash('message', 'Anda mempunyai pesanan pada layanan yang sama, <a href="/payment/'.$checServiceskOrder->code.'">lihat pesanan</a>.');
                        return redirect('/detail-services/'.$serviceId);
                    }
                }
            }

            // exit;

            $dataHeader = [
                'customer_code' => $user->code,
                'service_id' => $serviceId,
                'date' => date('Y-m-d'),
            ];

            if($checServiceskOrder) {
                if($checServiceskOrder->status == 'Y') {
                    $code = getLasCodeTransaction('R');
        
                    $dataHeader['code'] = $code;
                    ServiceOrder::create($dataHeader);
                } else {
                    $code = $checServiceskOrder->code;
                }
            } else {
                $code = getLasCodeTransaction('R');
    
                $dataHeader['code'] = $code;
                ServiceOrder::create($dataHeader);
            }
            
            return redirect('/payment/'.$code.'/true');
            
        }
        
    }
    
}
