<?php

namespace Modules\Carts\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Products\app\Models\Product;

class OrderhasProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["order_id", "product_id", "product_quantity"];
    
    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
