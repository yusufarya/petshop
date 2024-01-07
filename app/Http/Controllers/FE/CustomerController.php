<?php

namespace App\Http\Controllers\FE;

use App\Models\Customer;
use App\Models\SalesOrder;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    function index() {
        return view('user-page/auth/register', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request) {
        
        $validatedData = $request->validate([
            'fullname'      => 'required|max:50',
            'username'      => 'required|max:30|unique:customers',
            'gender'        => 'required',
            'phone'       => 'required',
            'email'         => 'required|email|unique:customers',
            'password'      => 'required|confirmed|min:6|max:255',
            'password_confirmation' => 'required|min:6|max:255'
        ]);
        
        $validatedData['fullname'] = ucwords($validatedData['fullname']);
        $validatedData['code'] = $this->getLasNumber();
        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['created_by'] = $validatedData['username'];
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['is_active'] = "Y";
        // dd($validatedData);
        $result = Customer::create($validatedData);
        if($result) {
            $request->session()->flash('success', 'Akun berhasil dibuat');
            return redirect('/login');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
            return redirect('/register');
        }
    }

    function login() {
        return view('user-page.auth.login', [
            'title' => 'Login'
        ]);
    }

    public function loginValidation(Request $request) {
        
        $credentials = $request->validate([
            'email'  => 'required',
            'password'  => 'required'
        ]);
        // dd($credentials);
        $resultUser = Customer::where('email', $credentials['email'])->count();
        
        if(!$resultUser) {
            $request->session()->flash('failed', 'Akun tidak terdaftar.');
            return redirect('/login');
        }
        // dd(auth('customer'));
        if (auth('customer')->attempt($credentials)) {
        
            $isActive = Auth::guard('customer')->user()->is_active == "Y";
            if ($isActive == true) { 
                return redirect()->intended('/');
            } else {
                Auth::guard('customer')->logout();
                $request->session()->flash('failed', 'Akun belum aktif, Hubungi Administrator.');
                return redirect('/login');
            }
        }

        return back()->with('failed', 'Username atau Password salah!');
    }

    function logout(Request $request) {
        Auth::guard('customer')->logout();
        
        $request->session()->flash('success', 'Anda berhasil logout');
        return redirect('/login');
    }

    function getLasNumber() {
        
        $lastNumber = Customer::max('code');

        if($lastNumber) {
            $lastNumber = substr($lastNumber, -4);
            $code_ = sprintf('%04d', $lastNumber+1);
            $numberFix = "PETS".date('Ymd').$code_;
        } else {
            $numberFix = "PETS".date('Ymd')."0001";
        }

        return $numberFix;
    }

    // USER PROFILE - CUSTOMER (Pelanggan) //

    function profile() {
        $filename = 'profile';
        $filename_script = getContentScript(false, $filename);
        
        if(!auth('customer')->user()) {
            return redirect('/login');
        }
        
        $customer = new Customer;
        $data = $customer->getUserProfile();

        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Profil Saya',
            'auth_user' => $data
        ]);
    }

    function updateProfile() {
        $filename = 'update_profile';
        $filename_script = getContentScript(false, $filename);

        $code = Auth::guard('customer')->user()->code;
        $data = Customer::where('code', $code)->first();  
        
        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Profil Saya',
            'auth_user' => $data,
        ]);
    }

    function updateProfileData(Request $request, string $code) {
        // dd($request);
        $validatedData = $request->validate([
            'fullname'      => 'required|max:45',
            'phone'         => 'required|max:15',
            'place_of_birth'=> 'required|max:30',
            'date_of_birth' => 'required',
            'city'       => 'required|max:30',
            'address'       => 'required|max:200',
            'image'     => 'file|image|max:1024',
        ]);

        // dd($validatedData);

        $getData = Customer::where(['code'=> $code])->first();
        
        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('profile-images');
            $is_valid_image = true;
        } else if ($getData->image) {
            $is_valid_image = true;
        } else {
            $is_valid_image = false;
            $request->session()->flash('image', 'Pas Foto belum di upload');
        }

        if(!$is_valid_image) {
            return redirect('/update-profile');
        }
        
        $result = Customer::where(['code'=> $code])->update($validatedData);
        if($result) {
            $request->session()->flash('success', 'Data Berhasil diperbaharui');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/_profile');
    }

    // Pesanan saya
    function myOrders(Request $request) {
        $status = $request->status ? $request->status : 'N';
        $delivery = $request->status ? $request->delivery : '';

        $filename = 'my_orders';
        $filename_script = getContentScript(false, $filename);

        $registrant = new Customer;
        $result = $registrant->getMyOrders($status, $delivery);
        // dd($result);
        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Daftar Pesanan ',
            'my_orders' => $result,
            'status' => $status,
            'delivery' => $delivery
        ]);
    }

    function myOrderDetail(string $code) {
        $data = SalesOrder::with('customers', 'salesOrderMany.products.categories', 'salesOrderMany.products.brands', 'salesOrderMany.products.sizes')
                            ->where('code', $code)->get();
        // dd($data);
        $filename = 'my_order_detail';
        $filename_script = getContentScript(false, $filename);
        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Detail Pesanan Saya ',
            'my_order_detail' => $data, 
        ]);
    }

    function accOrder(Request $request) {
        $code = substr($request->code, 0,2);
        // dd($request);
        $code = substr($request->code, 0,2);
        if($code == 'ST') {
            $result = SalesOrder::where('code', $request->code)->update(['delivery' => $request->delivery]);
        } else if($code == 'SE') {
            $result = ServiceOrder::where('code', $request->code)->update(['delivery' => $request->delivery]);
        }

        if($result) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }
}
