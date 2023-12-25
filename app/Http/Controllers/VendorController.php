<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {       
        $filename = 'vendor';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $data = Vendor::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Master Kategori',
            'auth_user' => $user,
            'dataVendor' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = Vendor::create(['name' => ucwords($request['name']), 'address' => ucwords($request['address'])]);
        if($result) {
            $request->session()->flash('success', 'Vendor berhasil dibuat');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/vendors');
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $result = Vendor::find($id)->update(['name'=>ucwords($request['name']), 'address' => ucwords($request['address'])]);
        if($result) {
            $request->session()->flash('success', 'Vendor berhasil diubah');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/vendors');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $result = Vendor::find($id)->delete();
        if($result) {
            $request->session()->flash('success', 'Vendor berhasil dihapus');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/vendors');
    }
}
