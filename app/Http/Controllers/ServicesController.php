<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filename = 'service';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $data = Service::with('categories')->orderBy('id', 'DESC')->get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Daftar Layanan',
            'auth_user' => $user,
            'resultData' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filename = 'service_add';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $category = Category::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Tambah Layanan Baru',
            'auth_user' => $user,
            'categories' => $category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->file('image'));
        $validatedData = $request->validate([
            'name'          => 'required|max:50',
            'category_id'   => 'required',
            'duration'      => 'required',
            'type'          => 'required',
            'stock'         => 'required',
            'price'         => 'required',
            'image'         => 'file|image|max:1024'
        ]);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('product-images');
        }
        
        $validatedData['name'] = ucwords($validatedData['name']);
        $validatedData['price'] = cleanSpecialChar($validatedData['price']);
        $validatedData['description'] = $request->description;
        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['created_by'] = Auth::guard('admin')->user()->username;
        // dd($validatedData);
        $result = Service::create($validatedData);
        if($result) {
            $request->session()->flash('success', 'Layanan berhasil dibuat');
            return redirect('/services');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            return redirect('/services/create');
        }
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
        $filename = 'product_edit';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $unit = Unit::get();
        $size = Size::get();
        $category = Category::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Ubah Layanan',
            'auth_user' => $user,
            'categories' => $category,
            'resultData' => Service::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        // dd($request->file('image'));
        $validatedData = $request->validate([
            'name'          => 'required|max:50',
            'category_id'   => 'required',
            'duration'      => 'required',
            'type'          => 'required',
            'stock'         => 'required',
            'price'         => 'required',
            'image'         => 'file|image|max:1024'
        ]);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('product-images');
        }
        
        $validatedData['name'] = ucwords($validatedData['name']);
        $validatedData['price'] = cleanSpecialChar($validatedData['price']);
        $validatedData['description'] = $request->description;
        $validatedData['updated_at'] = date('Y-m-d H:i:s');
        $validatedData['updated_by'] = Auth::guard('admin')->user()->username;
        // dd($validatedData);
        $result = Service::where(['id' => $id])->update($validatedData);
        if($result) {
            $request->session()->flash('success', 'Akun berhasil dibuat');
            return redirect('/services');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            return redirect('/services/create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $data = Service::find($id);
        $result = $data->delete();
        if($result) {
            $request->session()->flash('success', 'Layanan berhasil diubah');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/services');
    }
}
