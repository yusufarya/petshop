<?php

namespace App\Models;

use App\Models\Size;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceOrder extends Model
{
    use HasFactory;
    protected $table = 'service_orders';
    public $guarded = ['id'];
    public $primaryKey = 'code';
    public $keyType = 'string';
    public $timestamps = false;

    /**
     * Get the customers that owns the ServiceOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_code', 'code');
    }

    public function sizes(): BelongsTo
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }
}
