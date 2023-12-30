<?php

namespace App\Http\Controllers\FE;

use App\Models\Product;
use App\Models\Customer;
use App\Models\SalesOrder;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use App\Models\SalesOrderDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    // keranjang saya //
    function index() {
        $user = Auth::guard('customer')->user();
        $filename = 'shopping_carts';
        $filename_script = getContentScript(false, $filename);

        $result = ShoppingCart::with('customers', 'products.categories', 'products.sizes')->where(['customer_code' => $user->code, 'updated_at' => NULL])->get();
        // dd($result);
        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Keranjang Saya',
            'shopping_carts' => $result
        ]);
    }

    function store(Request $request,int $productId) {
        $user = Auth::guard('customer')->user();
        // dd($request);
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

            $checkShoppingCart = ShoppingCart::with('products', 'customers')
                                ->where(['customer_code' => $user->code, 'product_id' => $productId,])
                                ->first();
            // dd($checkShoppingCart);
            if(!$checkShoppingCart) {
                $data = [
                    'customer_code' => $user->code,
                    'product_id' => $productId,
                    'qty' => $request->qty
                ];
                // dd($data);
                ShoppingCart::create($data);
            } else {
                $data = [
                    'customer_code' => $user->code,
                    'product_id' => $productId,
                    'qty' => $request->qty,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                // dd($data);
                ShoppingCart::where(['customer_code' => $user->code])->update($data);
            }
            $request->session()->flash('message', 'Berhasil menambahkan ke keranjang.');
            return redirect('/detail-product/'.$productId);
            
        }
        
    }

    function submitCart(Request $request) {
        $requestId = explode(',', $request->id_cart);
        $seq = 1;
        
        $sales_code = getLasCodeTransaction('S');

        $dataHeader = [
            'code' => $sales_code,
            'customer_code' => Auth::guard('customer')->user()->code,
            'date' => date('Y-m-d'),
        ];

        $headerInserted = SalesOrder::create($dataHeader);
        if($headerInserted) {
            foreach ($requestId as $item) {
                $getCart = ShoppingCart::with('products')->where('id', $item)->first();
                
                $dataDetail = [
                    'sequence' => $seq++,
                    'sales_order_code' => $sales_code,
                    'product_id' => $getCart->product_id,
                    'date' => date('Y-m-d'),
                    'qty' => $getCart->qty,
                    'price' => $getCart->products->selling_price,
                ];
                
                $result = SalesOrderDetail::create($dataDetail);
            }

            $where = ['sales_order_code' => $sales_code];
        
            $qty = SalesOrderDetail::where($where)->sum('qty');
            $total_price = SalesOrderDetail::where($where)
                                            ->sum(DB::raw('price * qty'));

            $dataHeader = [
                'qty' => $qty,
                'total_price' => $total_price,
            ];
            // dd($dataHeader);
            $update = SalesOrder::where(['code' => $sales_code])->update($dataHeader);
            
            if($update) {
                foreach ($requestId as $item) {
                    ShoppingCart::where('id', $item)->delete();
                }

                return response()->json(['status' => 'success', 'code' => $sales_code]);
            } else {
                return response()->json(['status' => 'failed']);
            }
        }

    }
    
    function deleteCart(Request $request) {
        
        $requestId = explode(',', $request->arrCartId);
        foreach ($requestId as $item) {
            ShoppingCart::where('id', $item)->delete();
        }
        return true;
    }
}
