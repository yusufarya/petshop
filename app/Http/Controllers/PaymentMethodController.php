<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {       
        $filename = 'payment_method';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $data = PaymentMethod::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Metode Pembayaran',
            'auth_user' => $user,
            'resultData' => $data
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
        $result = PaymentMethod::create(['bank_name' => ucwords($request['bank_name']), 'account_number' => $request['account_number']]);
        if($result) {
            $request->session()->flash('success', 'Bank berhasil ditambahkan');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/payment-method');
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
        $result = PaymentMethod::find($id)->update(['bank_name'=>ucwords($request['bank_name']), 'account_number' => ucwords($request['account_number'])]);
        if($result) {
            $request->session()->flash('success', 'Bank berhasil diubah');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/payment-method');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $result = PaymentMethod::find($id)->delete();
        if($result) {
            $request->session()->flash('success', 'Bank berhasil diubah');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/payment-method');
    }
}
