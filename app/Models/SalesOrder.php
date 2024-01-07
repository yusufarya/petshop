<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesOrder extends Model
{
    use HasFactory;
    public $guarded = ['id'];
    public $primaryKey = 'code';
    protected $keyType = "string";
    public $timestamps = false;

    /**
     * Get the customers that owns the SalesOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_code', 'code');
    }
    
    public function salesOrderDetails(): BelongsTo
    {
        return $this->belongsTo(SalesOrderDetail::class, 'code', 'sales_order_code');
    }

    /**
     * Get all of the comments for the SalesOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function salesOrderMany(): HasMany
    {
        return $this->hasMany(SalesOrderDetail::class, 'sales_order_code', 'code');
    }
}
