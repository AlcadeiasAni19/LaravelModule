<?php

namespace Modules\Carts\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Carts\Database\factories\OrderFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["user_id", "order_code", "status", "total_price"];

    public function user():BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function orderHasProduct():HasMany {
        return $this->hasMany(Product::class);
    }
}
