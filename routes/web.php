<?php

use App\Models\Product;
use App\Http\Controllers\AuthAdmin;
use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\VendorController;
use App\Http\Controllers\FE\HomeController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\FE\ServiceController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\FE\CustomerController;
use App\Http\Controllers\UpdateStockController;
use App\Http\Controllers\FE\ProductFEController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseTransactionReport;
use App\Http\Controllers\TrainingContentController;
use App\Http\Controllers\PurchaseOrderDetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/getProducts', function () {
    $resultData = Product::with('categories', 'units', 'sizes', 'brands')->orderBy('id', 'ASC')->get();
    return response()->json(['status' => 'success', 'data' => $resultData]);
});

Route::middleware('guest')->group(function () {
    Route::get('/admin', function () {
        return redirect('/login-admin');
    });
    
    Route::get('/login-admin', [AuthAdmin::class, 'index']);
    Route::post('/login-admin', [AuthAdmin::class, 'auth']);
    Route::get('/register-admin', [AuthAdmin::class, 'register']);
    Route::post('/register-admin', [AuthAdmin::class, 'store']);
});


Route::middleware('admin')->group(function () {
    Route::get('/profile', [AdminController::class, 'index']);
    Route::get('/dashboard', [Dashboard::class, 'index']);
    
    Route::get('/data-admin', [AdminController::class, 'dataAdmin']);
    Route::get('/getDetailAdmin', [AdminController::class, 'getDetailAdmin']);
    Route::get('/form-add-admin', [AdminController::class, 'addFormAdmin']);
    Route::post('/add-new-admin', [AdminController::class, 'storeAdmin']);
    Route::get('/form-edit-admin/{number}', [AdminController::class, 'editFormAdmin']);
    Route::post('/edit-new-admin', [AdminController::class, 'updateAdmin']);

    Route::get('/data-customer', [AdminController::class, 'dataCustomer']);
    Route::get('/detail-customer/{code}', [AdminController::class, 'detailCustomer']); 
    
    // MODUL PERSEDIAAN // 
    Route::resource('/units', UnitController::class)->only("index", "store", "update", "destroy");
    Route::resource('/sizes', SizeController::class)->only("index", "store", "update", "destroy");
    Route::resource('/brands', BrandController::class)->only("index", "store", "update", "destroy");
    Route::resource('/categories', CategoryController::class)->only("index", "store", "update", "destroy");
    Route::resource('/products', ProductController::class);
    Route::resource('/services', ServicesController::class);
    Route::resource('/update-stock', UpdateStockController::class);
    
    Route::get('/inventories', [InventoryController::class, 'index']);
    Route::get('/detail-inventory', [InventoryController::class, 'detailInventory']);
    
    // ================ MODUL PEMBELIAN ================= // 
    // LIST DATA VENDOR
    Route::resource('/vendors', VendorController::class)->only("index", "store", "update", "destroy");

    // LIST PURCHASE TRANSACTION
    Route::get('/purchase-order', [PurchaseOrderController::class, 'index']);
    Route::delete('/delete-purchase-order/{id}', [PurchaseOrderController::class, 'deleteData']);
    // FORM ADD //
    Route::get('/purchase-order/create', [PurchaseOrderController::class, 'addData']);
    Route::post('/purchase-order/addDetail', [PurchaseOrderController::class, 'storeData']); // ADD TRANSACTION HEADER //
    // FORM Edit //
    Route::get('/purchase-order/{id}/edit', [PurchaseOrderController::class, 'editData']);
    Route::post('/purchase-order_detail/add', [PurchaseOrderDetailController::class, 'storeData']); // ADD TRANSACTION DETAIL //
    Route::post('/purchase-order_detail/edit', [PurchaseOrderDetailController::class, 'updateData']); // EDIT TRANSACTION DETAIL //
    Route::delete('/purchase-order_detail/delete', [PurchaseOrderDetailController::class, 'removeData']); // DELETE TRANSACTION DETAIL //
    
    Route::get('/purchase-order_detail/checkData', [PurchaseOrderDetailController::class, 'checkData']); // CHECK TRANSACTION DETAIL //
    Route::get('/getPurchase_order_detail/{id}', [PurchaseOrderDetailController::class, 'getAllDetail']); // GET TRANSACTION DETAIL BY PURCHASE ID //
    
    Route::get('/purchase-report', [PurchaseTransactionReport::class, 'index']); // VIEW REPORT PURCASE TRANSACTION //
    Route::get('/purchase-rpt', [PurchaseTransactionReport::class, 'purchaseReport']); // SROTE REQUEST TO SESSION //
    Route::get('/open-purchase-rpt', [PurchaseTransactionReport::class, 'openPurchaseReport']); // OPEN REPORT PURCASE TRANSACTION //

    Route::post('/submit-purchase_order', [PurchaseOrderController::class, 'submitData']); // SUBMIT TRANSACTION HEADER //
    
    // LIST SALES ORDER TRANSACTION //
    Route::get('/sales-order', [SalesOrderController::class, 'index']);
    Route::delete('/delete-sales-order/{id}', [SalesOrderController::class, 'deleteData']);
    
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::post('/settings', [SettingsController::class, 'update']);
    Route::get('/set-period', [SettingsController::class, 'setPeriod']);
    Route::post('/set-period', [SettingsController::class, 'savePeriodActive']);
    
    Route::post('/logout-admin', [AuthAdmin::class, 'logout']);
});

Route::get('/', [HomeController::class, 'index']);

Route::get('/our-products', [ProductFEController::class, 'index']);
Route::get('/our-products/{id}', [ProductFEController::class, 'index']);
Route::get('/detail-product/{id}', [ProductFEController::class, 'detail']);
Route::get('/getDataProducts', [ProductFEController::class, 'getDataProducts']);

Route::middleware('customer')->group(function () {
    Route::get('/wishlist', [CustomerController::class, 'wishlist']);
    Route::get('/_profile', [CustomerController::class, 'profile']);
    Route::get('/update-profile', [CustomerController::class, 'updateProfile']);
    Route::put('/update-profile/{number}', [CustomerController::class, 'updateProfileData']);
    Route::get('/getVillages/', [GeneralController::class, 'getVillages']);
    Route::get('/checkDataUser/{id}', [GeneralController::class, 'checkDataUser']);
    
    Route::post('/logout', [CustomerController::class, 'logout']);
});

Route::get('/register', [CustomerController::class, 'index']);
Route::post('/register', [CustomerController::class, 'store']);
Route::get('/login', [CustomerController::class, 'login']);
Route::post('/login', [CustomerController::class, 'loginValidation']);
