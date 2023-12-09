<?php

namespace Modules\Carts\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Products\app\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["user_id", "product_id", "product_quantity"];
    
    public function product():BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function user():BelongsTo {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
