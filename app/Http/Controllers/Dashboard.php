<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\SalesOrder;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Models\SalesOrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Dashboard extends Controller
{
    
    public function __construct(protected Admin $admin) {
        $user = Auth::guard('admin')->user();
    }
    
    function index() {
        $cur_route = Route::current()->uri();
        $data = Auth::guard('admin')->user();
        if($data->level_id == 3) {
            return redirect('/delivery');
        }
        return view('admin-page.dashboard', [
            'title' => 'Dashboard',
            'cur_page' => $cur_route,
            'auth_user' => $data,
            'newOrder' => SalesOrder::with('customers')->orderBy('code', 'DESC')->where(['status'=> 'N'])->count(),
            'salesOrder' => SalesOrder::with('customers')->orderBy('code', 'DESC')->where(['status'=> 'Y'])->count(),
            'serviceOrder' => ServiceOrder::with('customers')->orderBy('code', 'DESC')->count(),
            'salesOrderData' => SalesOrderDetail::with('products.categories', 'products.sizes')->orderBy('sales_order_code', 'DESC')->offset(0)->limit(4)->get(),
        ]);
    }
}
