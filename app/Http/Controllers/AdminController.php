<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\AdminLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class AdminController extends Controller
{
    function index() {
        $code = Auth::guard('admin')->user()->code;
        $data = Admin::with('admin_level')->find($code)->first();  
        return view('admin-page.profile', [
            'title' => 'Profile',
            'auth_user' => $data
        ]);
    }
    
    function dataAdmin() {
        $filename = 'data_admin';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();  
        $admin = Admin::with('admin_level')->get();  
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Admin',
            'auth_user' => $data,
            'dataAdmin' => $admin
        ]);
    }

    function getDetailAdmin(Request $request) {
        $code = $request->code;
        $data = Admin::with('admin_level')->find($code)->first();
        dd($data);
        $data->address = $data->address ? $data->address : " - ";
        $data->place_of_birth = $data->place_of_birth ? $data->place_of_birth : " - ";
        $data->date_of_birth = $data->date_of_birth ? date('d-m-Y', strtotime($data->date_of_birth)) : " - - -";
        $data->created_at = date('d-m-Y', strtotime($data->created_at));
        $data->gender = $data->gender == "M" ? "Laki-laki" : "Perempuan";
        $data->level = $data->admin_level->name;
        echo json_encode($data);
    }

    function addFormAdmin() {
        $filename = 'add_new_admin';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();  
        $admin = Admin::with('admin_level')->get();  
        $admin_level = AdminLevel::get();  
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Tambah Data Admin',
            'auth_user' => $data,
            'level' => $admin_level
        ]);
    }

    function storeAdmin(Request $request) {

        $validatedData = $request->validate([
            'fullname'      => 'required|max:50',
            'username'      => 'required|max:30|unique:admins',
            'gender'        => 'required',
            'level_id'        => 'required',
            'place_of_birth'    => 'required|max:40',
            'date_of_birth'     => 'required',
            'phone'       => 'required|max:15',
            'email'         => 'required|max:100|email|unique:admins',
            'password'      => 'required|min:6|max:255',
            'image'         => 'file|image|max:1024',
        ]);
        
        
        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('user-images');
        }

        $validatedData['code'] = getLasCodeAdmin();
        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['created_by'] = Auth::guard('admin')->user()->username;
        $validatedData['password'] = Hash::make($validatedData['password']);
        // $validatedData['level_id'] = 1;
        // dd($validatedData);
        $result = Admin::create($validatedData);
        if($result) {
            $request->session()->flash('success', 'Akun berhasil dibuat');
            return redirect('/data-admin');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            return redirect('/form-add-admin');
        }
        
    }

    function editFormAdmin($code, $page = '') {
        
        $filename = 'edit_new_admin';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();
        $data_admin = Admin::find($code);
        $admin_level = AdminLevel::get();  
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Edit Data Admin',
            'auth_user' => $data,
            'data_admin' => $data_admin,
            'level' => $admin_level,
            'page_' => $page ? $page : ''
        ]);
    }

    function updateAdmin(Request $request, $page = '') {
        
        $validatedData = $request->validate([
            'fullname'      => 'required|max:50',
            'username'      => 'required|max:30',
            'gender'        => 'required',
            'phone'         => 'required|max:15',
            'level_id'      => 'required',
            'place_of_birth'=> 'required|max:40',
            'date_of_birth' => 'required',
            'address'       => 'required',
            'image'         => 'file|image|max:1024',
        ]);
        
        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('user-images');
        }
        
        $username_exist = false;
        if($request['username1'] != $request['username']) {
            $username_exist = Admin::where('username', $request['username'])->first();
        }
        
        $validatedData['code'] = $request['code'];
        $validatedData['updated_at'] = date('Y-m-d H:i:s');
        $validatedData['updated_by'] = Auth::guard('admin')->user()->username;
        if($request['password']) {
            $request['password'] = Hash::make($request['password']);
        }
        $validatedData['level_id'] = $validatedData['level_id'];
        
        if($username_exist === false) {
            $result = Admin::where(['code' => $validatedData['code']])->update($validatedData);
            // dd($result);
            if($result) {
                $request->session()->flash('success', 'Akun berhasil dibuat');
                if($page == "profile") {
                    return redirect('/profile');
                } else {
                    return redirect('/data-admin');
                }
            } else {
                $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
                return redirect('/form-edit-admin/'.$validatedData['code']);
            }
        } else {
            $request->session()->flash('failed', 'Username sudah ada');
            return redirect('/form-edit-admin/'.$validatedData['code']);
        }

    }
    
    function deleteAdmin(Request $request, string $code) {

        if(auth()->guard('admin')->user()->code == $code) {
            $request->session()->flash('failed', 'Proses gagal, Anda tidak dapat menghapus akun anda sendiri');
            return redirect('/data-admin');
        }
        $data = Admin::where(['code' => $code]);
        $result = $data->delete();
        if($result) {
            $request->session()->flash('success', 'Transaksi berhasil diubah');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/data-admin');
    }

    function dataCustomer() {
        $filename = 'data_customer';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();  
        $dataCustomers = Customer::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Pelanggan',
            'auth_user' => $data,
            'dataCustomers' => $dataCustomers
        ]);
    }

    function detailCustomer(string $code) {
        $filename = 'detail_customer';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();  
        $customer = new Customer;
        $data_part = $customer->getUserProfileById($code);
        // dd($customer);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Detail Pelanggan',
            'auth_user' => $data,
            'detailCustomer' => $data_part
        ]);
    }
    
    
}
