<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filename = 'product';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $data = Product::with('categories', 'units', 'sizes')->orderBy('id', 'DESC')->get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Daftar Produk',
            'auth_user' => $user,
            'resultData' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filename = 'product_add';
        $filename_script = getContentScript(true, $filename);

        $user = Auth::guard('admin')->user();
        $unit = Unit::get();
        $size = Size::get();
        
        $category = Category::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Tambah Produk Baru',
            'auth_user' => $user,
            'units' => $unit,
            'sizes' => $size,
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
            'unit_id'       => 'required',
            'size_id'       => 'required',
            'purchase_price'=> 'required',
            'selling_price' => 'required',
            'image'         => 'file|image|max:1024'
        ]);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('product-images');
        }
        
        $validatedData['name'] = ucwords($validatedData['name']);
        $validatedData['purchase_price'] = cleanSpecialChar($validatedData['purchase_price']);
        $validatedData['selling_price'] = cleanSpecialChar($validatedData['selling_price']);
        $validatedData['description'] = $request->description;
        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['created_by'] = Auth::guard('admin')->user()->username;
        // dd($validatedData);
        $result = Product::create($validatedData);
        if($result) {
            $request->session()->flash('success', 'Akun berhasil dibuat');
            return redirect('/products');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            return redirect('/products/create');
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
            'title' => 'Tambah Produk Baru',
            'auth_user' => $user,
            'units' => $unit,
            'sizes' => $size,
            'categories' => $category,
            'resultData' => Product::find($id)
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
            'unit_id'       => 'required',
            'size_id'       => 'required',
            'purchase_price'=> 'required',
            'selling_price' => 'required',
            'image'         => 'image|file|max:1024'
        ]);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('product-images');
        }
        
        $validatedData['name'] = ucwords($validatedData['name']);
        $validatedData['purchase_price'] = cleanSpecialChar($validatedData['purchase_price']);
        $validatedData['selling_price'] = cleanSpecialChar($validatedData['selling_price']);
        $validatedData['description'] = $request->description;
        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['created_by'] = Auth::guard('admin')->user()->username;
        // dd($validatedData);
        $result = Product::where(['id' => $id])->update($validatedData);
        if($result) {
            $request->session()->flash('success', 'Akun berhasil dibuat');
            return redirect('/products');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            return redirect('/products/create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $data = Product::find($id);
        $result = $data->delete();
        if($result) {
            $request->session()->flash('success', 'Produk berhasil diubah');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/products');
    }
}
