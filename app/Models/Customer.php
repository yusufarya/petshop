<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\SalesOrder;
use App\Models\SubDistrict;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $primaryKey = 'code';
    public $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'code',
        'fullname',
        'username',
        'gender',
        'phone', 
        'place_of_birth',
        'date_of_birth',
        'address', 
        'is_active', 
        'email',
        'password',
        'created_at', 
        'updated_at', 
    ];

    public function getUserProfile() {
        $code = auth('customer')->user()->code;
        $data = DB::table('customers')
            ->select('customers.*')
            ->where(['code' => $code])
            ->first();
        return $data;
    }

    public function getUserProfileById($code) {
        $data = DB::table('customers')
            ->select('customers.*')
            ->where(['code' => $code])
            ->first();
        return $data;
    }

    function getShoppingCarts() {
        return DB::table('shopping_carts')
                ->select('shopping_carts.*', 'customers.fullname as customer_name', 'products.name as product_name')
                ->leftJoin('customers', 'customers.code', '=', 'shopping_carts.customer_code')
                ->leftJoin('products', 'products.id', '=', 'shopping_carts.product_id') 
                // ->leftJoin('categories', 'categories.id', '=', 'trainings.category_id')
                ->where(['customer_code' => Auth::guard('customer')->user()->code])->get();
    }
    
    function getMyOrders($status, $delivery) {
        $where_ = ['customer_code' => Auth::guard('customer')->user()->code];

        if($status && $status != "00") {
            $where_['status'] = $status;
        } else if($status == '00') {
            unset($where_['status']);
        }

        if($delivery) {
            $where_['delivery'] = $delivery;
        }

        // dd($where_);
        // return DB::table('sales_orders')
        //         ->select('sales_orders.*')
        //         ->leftJoin('customers', 'customers.code', '=', 'sales_orders.customer_code')
        //         ->leftJoin('sales_order_details', 'sales_order_details.sales_order_id', '=', 'sales_orders.id') 
        //         // ->leftJoin('categories', 'categories.id', '=', 'trainings.category_id')
        //         ->where(['customer_code' => Auth::guard('customer')->user()->code])->get();

        $data = SalesOrder::with('customers', 'salesOrderDetails.products.categories', 'salesOrderDetails.products.brands', 'salesOrderDetails.products.sizes')
                            ->where($where_)->orderBy('code', 'DESC')->get();
        return $data;
    }
    
   
    function getMyReqOrders($status, $delivery) {
        $where_ = ['customer_code' => Auth::guard('customer')->user()->code];

        if($status && $status != "00") {
            $where_['status'] = $status;
        } else if($status == '00') {
            unset($where_['status']);
        }

        if($delivery) {
            $where_['delivery'] = $delivery;
        }

        // dd($where_);
        // return DB::table('sales_orders')
        //         ->select('sales_orders.*')
        //         ->leftJoin('customers', 'customers.code', '=', 'sales_orders.customer_code')
        //         ->leftJoin('sales_order_details', 'sales_order_details.sales_order_id', '=', 'sales_orders.id') 
        //         // ->leftJoin('categories', 'categories.id', '=', 'trainings.category_id')
        //         ->where(['customer_code' => Auth::guard('customer')->user()->code])->get();

        $data = RequestOrder::with('customers', 'sizes')
                            ->where($where_)->get();
        return $data;
    }
    
}
