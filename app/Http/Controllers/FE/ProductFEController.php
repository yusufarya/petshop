<?php

namespace App\Http\Controllers\FE;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductFEController extends Controller
{
    function index($id = '') {
        $filename = 'products';
        $filename_script = getContentScript(false, $filename);
        // dd($filename_script);
        $category = Category::get();
        $products = Product::where(['is_active' => 'Y'])->get();
        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Home',
            'category' => $category,
            'id_cat' => $id,
            'products' => $products,
        ]);
    }

    function getDataProducts(Request $request) {
        $active = "Y";
        $categorySelected = $request->categoryId;
        if($categorySelected) {
            $filter = ['is_active' => (string)$active, 'category_id' => $categorySelected];
        } else {
            $filter = ['is_active' => (string)$active];
        }
        $search_name = $request->search_name;

        $products = Product::with('categories', 'sizes')
                            ->where($filter)
                            ->where('name', 'like', '%' . $search_name . '%')
                            ->get();
                            
        $result = array('status' => 'success', 'products' => $products);
        
        echo json_encode($result);

    }

    function detail(int $id) {
        $filename = 'products_detail';
        $filename_script = getContentScript(false, $filename);
        
        $category = Category::get();
        $product = Product::with('categories', 'sizes', 'brands', 'inventory')->find($id);
        // dd($product);
        if(!$product) {
            return redirect('/our-product');
        }
        
        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Home',
            'category' => $category,
            'product' => $product,
            // 'setting' => Setting::find(2)
        ]);
    }
}
