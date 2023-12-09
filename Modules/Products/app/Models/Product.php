<?php

namespace Modules\Products\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Categories\app\Models\Category;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["name", "quantity", "stock", "unit", "price", "user_id", "category_id"];
    
    public function user():BelongsTo {
        return $this->belongsTo(User::class,"user_id", "id");
    }

    public function category():BelongsTo {
        return $this->belongsTo(Category::class,"category_id", "id");
    }

    public function review():HasMany {
        return $this->hasMany(Review::class,"product_id","id");
    }

    public function wishlist():BelongsTo {
        return $this->belongsTo(Wishlist::class,"product_id", "id");
    }
}
