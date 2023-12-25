<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use Illuminate\Support\Facades\Auth;

class SalesOrderController extends Controller
{
    function index() {
        $filename = 'purchase_order';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $data = SalesOrder::with('vendor')->orderBy('id', 'DESC')->get();
        // dd($data);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Penjualan ',
            'auth_user' => $user,
            'resultData' => $data
        ]);
    }
    
    function addData() {
        $filename = 'purchase_order_add';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $vendor = Vendor::get();
        // dd($data);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Tambah Penjualan ',
            'auth_user' => $user,
            'vendor' => $vendor,
        ]);
    }
    
    function editData(int $id) {
        $filename = 'purchase_order_edit';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $vendor = Vendor::get();
        $data = SalesOrder::where(['id' => $id])->first();
        // dd($data);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Tambah Penjualan ',
            'auth_user' => $user,
            'vendor' => $vendor,
            'resultData' => $data,
        ]);
    }

    function storeData(Request $request) {
        
        $data = [
            'vendor_code' => $request->vendor_code,
            'date' => $request->date,
        ];

        $insertedId = DB::table('purchase_orders')->insertGetId($data);
        
        if($insertedId) {
            return response()->json(['status' => 'success', 'dataId' => $insertedId]);
        } else {
            return response()->json(['status' => 'failed']);
        }

    }

    public function deleteData(Request $request, int $id)
    {
        $data = SalesOrder::find($id);
        $result = $data->delete();
        if($result) {
            $request->session()->flash('success', 'Transaksi berhasil diubah');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/purchase-order');
    }

    function submitData(Request $request) {

        $where = ['purchase_order_id' => $request->purchase_order_id];
        
        $qty = SalesOrderDetail::where($where)->sum('qty');
        $total_price = SalesOrderDetail::where($where)->sum('price');

        $data = [
            'qty' => $qty,
            'total_price' => $total_price,
        ];

        $update = DB::table('purchase_orders')->where(['id' => $request->purchase_order_id])->update($data);
        
        if($update) {
            return response()->json(['status' => 'success', 'dataId' => $update]);
        } else {
            return response()->json(['status' => 'failed']);
        }

    }
}