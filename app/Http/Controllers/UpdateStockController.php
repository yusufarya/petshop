<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\InventoryUpdates;
use Illuminate\Support\Facades\Auth;

class UpdateStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filename = 'update_stock';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $data = InventoryUpdates::with('products.categories', 'products.units', 'products.sizes')->orderBy('id', 'DESC')->get();
        // dd($data);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Update Stok Produk',
            'auth_user' => $user,
            'resultData' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filename = 'update_stock_add';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $products = Product::with('categories', 'units', 'sizes', 'brands')->orderBy('id', 'DESC')->get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Update Stok Produk',
            'auth_user' => $user,
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataUpdateStock = [
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'date' => date('Y-m-d H:i:s'),
            'price' => cleanSpecialChar($request->price),
        ];
        
        // Qty baru input
        $newQty = $request->qty; 

        $result = InventoryUpdates::create($dataUpdateStock);
        
        $checkInventory = Inventory::where(['product_id' => $request->product_id])->first();
        // dd($checkInventory);
        if (!$checkInventory) {
            Inventory::create(['product_id' => $request->product_id, 'stock' => $request->qty ]);
        } else {
            $qtyInStock = $checkInventory->stock;
            
            $stockFix = $qtyInStock + $newQty;
            // dd($stockFix);
            Inventory::where(['product_id' => $request->product_id])->update(['product_id' => $request->product_id, 'stock' => $stockFix ]);
        }
        
        if($result) {
            $request->session()->flash('success', 'Stok Produk berhasil dibuat');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/update-stock');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $filename = 'update_stock_edit';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $products = Product::with('categories', 'units', 'sizes', 'brands')->orderBy('id', 'DESC')->get();
        $data = InventoryUpdates::find($id);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Update Stok Produk',
            'auth_user' => $user,
            'products' => $products,
            'resultData' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $dataUpdateStock = [
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'price' => cleanSpecialChar($request->price),
        ];

        // Qty baru input
        $newQty = $request->qty; 

        $resultCurentQty = InventoryUpdates::where(['id' => $id, 'product_id' => $request->product_id])->first();
        
        // Qty saat ini (sebelum input)
        $curentStock = $resultCurentQty->qty;

        $result = InventoryUpdates::where(['id' => $id])->update($dataUpdateStock);
        
        $checkInventory = Inventory::where(['product_id' => $request->product_id])->first();
        if (!$checkInventory) {
            Inventory::create(['product_id' => $request->product_id, 'stock' => $request->qty ]);
        } else {
            $qtyInStock = $checkInventory->stock;
            // echo  $qtyInStock ." - ". $curentStock ." + ". $newQty; 
            $stockFix = $qtyInStock - $curentStock + $newQty;
            // dd($stockFix);
            Inventory::where(['product_id' => $request->product_id])->update(['product_id' => $request->product_id, 'stock' => $stockFix ]);
        }

        if($result) {
            $request->session()->flash('success', 'Stok Produk berhasil dibuat');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/update-stock');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $resultCurentQty = InventoryUpdates::where(['id' => $id, 'product_id' => $request->product_id])->first();
        // Qty saat ini (sebelum input)
        $curentStock = $resultCurentQty->qty;
        $result = InventoryUpdates::where(['id' => $id])->delete();
        
        if($result) {
            $checkInventory = Inventory::where(['product_id' => $request->product_id])->first();
            $qtyInStock = $checkInventory ? $checkInventory->stock : 0;
            // echo $newQty; 
            $stockFix = $qtyInStock - $curentStock;
            // dd($stockFix);
            Inventory::where(['product_id' => $request->product_id])->update(['stock' => $stockFix ]);
            
            return redirect('/update-stock');
        }
    }
}
