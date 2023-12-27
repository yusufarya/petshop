<?php

namespace App\Http\Controllers;

use App\Models\DeliveryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filename = 'delivery_type';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $data = DeliveryType::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Jenis Pengiriman',
            'auth_user' => $user,
            'dataCategory' => $data
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
        $dataInsert = [
            'name' => ucwords($request['name']), 
            'description' => ucwords($request['description']), 
            'charge' => cleanSpecialChar($request['charge'])
        ];
        $result = DeliveryType::create($dataInsert);
        if($result) {
            $request->session()->flash('success', 'Jenis Pengiriman berhasil dibuat');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/delivery-types');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $dataUpdate = [
            'name' => ucwords($request['name']), 
            'description' => ucwords($request['description']), 
            'charge' => cleanSpecialChar($request['charge'])
        ];
        $result = DeliveryType::find($id)->update($dataUpdate);
        if($result) {
            $request->session()->flash('success', 'Datta berhasil diubah');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/delivery-types');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $result = DeliveryType::find($id)->delete();
        if($result) {
            $request->session()->flash('success', 'Data berhasil dihapus');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/delivery-types');
    }
}
