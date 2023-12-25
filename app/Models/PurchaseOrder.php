<?php

namespace App\Models;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Model
{
    use HasFactory;

    public $guarded = ['id'];
    public $timestamps = false;

    // public function products(): BelongsTo
    // {
    //     return $this->belongsTo(Product::class, 'product_id', 'id');
    // } 
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_code', 'code');
    } 
}
