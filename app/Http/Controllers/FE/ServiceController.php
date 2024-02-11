<?php

namespace App\Http\Controllers\FE;

use DateTime;
use App\Models\Period;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Customer;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Models\TrainingDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

    function store(Request $request) {

        $user = Auth::guard('customer')->user();
        
        if($user->place_of_birth == null OR
            $user->date_of_birth == null OR 
            $user->phone == null OR 
            $user->address == null
        ) {
            $request->session()->flash('message', 'Anda belum bisa melakukan pemesanan, lengkapi data untuk melanjutkan.');
            return redirect('/service-form');
        } else {
            $user = Auth::guard('customer')->user();
    
            $validateData = $request->validate([
                'category_id' => 'required',
                'image' => 'file|image|max:1024'
            ]);

            if($request->file('image')) {
                $data['image'] = $request->file('image')->store('service-images');
            }
            
            $data = [
                'code' => $request->code,
                'customer_code' => $user->code,
                'pick_up' => $request->pick_up,
                'category_id' => $user->category_id,
                'custody' => $request->custody,
                'grooming_code' => $request->grooming_code,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'price' => cleanSpecialChar($request->price),
                'nett' => cleanSpecialChar($request->price),
            ];
            // dd($data);
            // $tgl1 = new DateTime($request->start_date);
            // $tgl2 = new DateTime($request->end_date);
            // $jarak = $tgl2->diff($tgl1);

            // dd($jarak->days);
            
            if($request->file('image')) {
                $data['image'] = $request->file('image')->store('request-images');
            }
            
            $result = ServiceOrder::create($data);
            if($result) {
                $request->session()->flash('success', 'Akun berhasil dibuat');
                return redirect('/payment-service/'.$request->code);
            } else {
                die('Proses gagal, Hubungi administrator');
            }
        }
    }

    
    // layanan Pesanan saya
    function myServiceOrders(Request $request) {
        // dd($request);
        $status = $request->status ? $request->status : 'N';
        $delivery = $request->status == 'Y' ? $request->delivery : '';

        $filename = 'my_service_orders';
        $filename_script = getContentScript(false, $filename);

        $registrant = new Customer;
        $result = $registrant->getMyReqOrders($status, $delivery);
        // dd($result);
        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Riwayat Pesanan Layanan ',
            'my_orders' => $result,
            'status' => $status,
            'delivery' => $delivery
        ]);
    }
}
