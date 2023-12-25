<?php

namespace App\Models;

use App\Models\Size;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public $guarded = ['id'];
    
    public $timestamps = false;

    /**
     * Get the user that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function brands(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    public function units(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    public function sizes(): BelongsTo
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'id', 'product_id');
    }
}
