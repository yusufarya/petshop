<?php

namespace App\Models;

use App\Models\Product;
use App\Models\SalesOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesOrderDetail extends Model
{
    use HasFactory;

    public $table = 'sales_order_details';
    public $guarded = ['id'];
    public $timestamps = false;

    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_code', 'code');
    } 
    
    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    } 
}
