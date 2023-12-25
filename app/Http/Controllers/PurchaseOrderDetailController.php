<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\InventoryUpdates;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderDetail;

class PurchaseOrderDetailController extends Controller
{

    function checkData(Request $request) {
        $result = DB::table('purchase_order_details')->where(['purchase_order_id'=> $request->purchase_order_id])->get();
        if($result) {
            return response()->json(['status' => 'success', 'data' => $result]);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }

    function storeData(Request $request) {

        $data = [
            'purchase_order_id' => $request->purchase_order_id,
            'sequence' => $request->sequence,
            'product_id' => $request->product_id,
            'date' => $request->date,
            'qty' => $request->qty_dt,
            'price' => cleanSpecialChar($request->price_dt),
        ];

        $insertedId = DB::table('purchase_order_details')->insertGetId($data);

        // Qty baru input
        $newQty = $request->qty_dt; 

        $checkInventory = Inventory::where(['product_id' => $request->product_id])->first();
        // dd($checkInventory);
        if (!$checkInventory) {
            Inventory::create(['product_id' => $request->product_id, 'stock' => $request->qty_dt ]);
        } else {
            $qtyInStock = $checkInventory->stock;
            
            $stockFix = $qtyInStock + $newQty;
            // dd($stockFix);
            Inventory::where(['product_id' => $request->product_id])->update(['product_id' => $request->product_id, 'stock' => $stockFix ]);
        }
        
        if($insertedId) {
            return response()->json(['status' => 'success', 'dataId' => $insertedId]);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }

    function updateData(Request $request) {

        $data = [
            'qty' => $request->qty_dt,
            'price' => cleanSpecialChar($request->price_dt),
        ];
        
        $get_product_id = DB::table('products')->where(['name' => trim($request->product_name)])->first();
        $product_id = $get_product_id->id;
        // Qty baru input
        $newQty = $request->qty_dt; 

        $resultCurentQty = PurchaseOrderDetail::where(['sequence' => $request->sequence, 'purchase_order_id'=> $request->purchase_order_id])->first();
        // Qty saat ini (sebelum input)
        $curentStock = $resultCurentQty->qty;

        $update = DB::table('purchase_order_details')->where(['sequence' => $request->sequence, 'purchase_order_id'=> $request->purchase_order_id])->update($data);
        
        $checkInventory = Inventory::where(['product_id' => $product_id])->first();
        if (!$checkInventory) {
            Inventory::create(['product_id' => $product_id, 'stock' => $request->qty_dt ]);
        } else {
            $qtyInStock = $checkInventory->stock;
            // echo  $qtyInStock ." - ". $curentStock ." + ". $newQty; 
            // echo "<br>";
            $stockFix = $qtyInStock - $curentStock + $newQty;
            // print($stockFix);
            Inventory::where(['product_id' => $product_id])->update(['stock' => $stockFix ]);
        }
        if($update) {
            return response()->json(['status' => 'success', 'result' => $update]);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }
    
    function removeData(Request $request) {
        $resultCurentQty = PurchaseOrderDetail::where(['sequence' => $request->sequence, 'purchase_order_id'=> $request->purchase_order_id])->first();
        $curentStock = $resultCurentQty->qty;

        $delete = DB::table('purchase_order_details')->where(['sequence' => $request->sequence, 'purchase_order_id'=> $request->purchase_order_id])->delete();
        
        if($delete) {
            $get_product_id = DB::table('products')->where(['name' => trim($request->product_name)])->first();
            $product_id = $get_product_id->id;

            $checkInventory = Inventory::where(['product_id' => $product_id])->first();
            $qtyInStock = $checkInventory ? $checkInventory->stock : 0;
            // echo $newQty; 
            $stockFix = $qtyInStock - $curentStock;
            // dd($stockFix);
            Inventory::where(['product_id' => $product_id])->update(['stock' => $stockFix ]);

            return response()->json(['status' => 'success', 'result' => $delete]);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }

    function getAllDetail(int $id) {
        
        $resuldData = PurchaseOrderDetail::with('products.categories', 'products.sizes', 'products.units')->where(['purchase_order_id' => $id])
                        ->orderBy('sequence', 'ASC')->get();

        if ($resuldData) {
            return response()->json(['status' => 'success', 'data' => $resuldData]);
        } else {
            return response()->json(['status' => 'failed']);
        }

    }
}
