<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShoppingCart extends Model
{
    use HasFactory;
    protected $table = 'shopping_carts';
    public $guarded = ['id'];
    public $timestamps = false;

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    } 

    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_code', 'code');
    }
}
