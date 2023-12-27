<?php

namespace App\Models;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderPayment extends Model
{
    use HasFactory;
    public $guarded = ['id'];
    public $primaryKey = 'code';
    public $keyType = 'string';
    
    public $timestamps = false;

    /**
     * Get the user that owns the OrderPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment_methods(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
    
}
