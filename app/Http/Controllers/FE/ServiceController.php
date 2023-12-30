<?php

namespace App\Http\Controllers\FE;

use App\Models\Period;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\TrainingDetail;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    function index() {
        $filename = 'services';
        $filename_script = getContentScript(false, $filename);
        // dd($filename_script);
        $category = Category::get();
        $services = Service::where(['is_active' => 'Y'])->get();
        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'brand_name' => 'PETSHOP',
            'title' => 'Home',
            'category' => $category,
            'services' => $services,
        ]);
    }

    function getDataServices(Request $request) {
        
        $categorySelected = $request->categoryId;
        if($categorySelected) {
            $filter = ['is_active' => 'Y', 'category_id' => $categorySelected];
        } else {
            $filter = ['is_active' => 'Y'];
        }

        $services = Service::with('categories')->where($filter)->get();
        
        $result = array('status' => 'success', 'services' => $services);
        
        echo json_encode($result);

    }

    function detail(int $id) {
        $category = Category::get();
        $services = Service::with('categories')->find($id);
        
        if(!$services) {
            return redirect('/pelatihan');
        }
        
        return view('user-page/services_detail', [
            'brand_name' => 'PETSHOP',
            'title' => 'Home',
            'category' => $category,
            'service' => $services,
        ]);
    }

    function serviceForm() {
        $filename = 'service_form';
        $filename_script = getContentScript(false, $filename);
        // dd($filename_script);
        $category = Category::get();
        $services = Service::where(['is_active' => 'Y'])->get();
        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'brand_name' => 'PETSHOP',
            'title' => 'Form Layanan',
            'category' => $category,
            'services' => $services,
        ]);
    }
}
