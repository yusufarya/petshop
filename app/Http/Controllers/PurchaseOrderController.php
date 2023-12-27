<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    function index() {
        $filename = 'purchase_order';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $data = PurchaseOrder::with('vendor')->orderBy('code', 'DESC')->get();
        // dd($data);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Pembelian ',
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
            'title' => 'Tambah Pembelian ',
            'auth_user' => $user,
            'vendor' => $vendor,
        ]);
    }
    
    function editData(string $code) {
        $filename = 'purchase_order_edit';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $vendor = Vendor::get();
        $data = PurchaseOrder::find($code)->first();
        // dd($data);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Tambah Pembelian ',
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
        
        $code = getLasCodeTransaction('P');

        $data['code'] = $code;

        $inserted = PurchaseOrder::create($data);
        
        if($inserted) {
            return response()->json(['status' => 'success', 'code' => $code]);
        } else {
            return response()->json(['status' => 'failed']);
        }

    }

    public function deleteData(Request $request, string $code)
    {
        $data = PurchaseOrder::find($code);
        $result = $data->delete();
        if($result) {
            $request->session()->flash('success', 'Transaksi berhasil diubah');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/purchase-order');
    }

    function submitData(Request $request) {

        $where = ['purchase_order_code' => $request->purchase_order_code];
        
        $qty = PurchaseOrderDetail::where($where)->sum('qty');
        $total_price = PurchaseOrderDetail::where($where)->sum('price');

        $data = [
            'qty' => $qty,
            'total_price' => $total_price,
        ];

        $update = DB::table('purchase_orders')->where(['code' => $request->purchase_order_code])->update($data);
        
        if($update) {
            return response()->json(['status' => 'success', 'dataId' => $update]);
        } else {
            return response()->json(['status' => 'failed']);
        }

    }
}
