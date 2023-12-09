<?php

namespace Modules\Products\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["description", "user_id", "product_id", "parent_id"];
    
    public function user():BelongsTo {
        return $this->belongsTo(User::class,"user_id", "id");
    }

    public function product():BelongsTo {
        return $this->belongsTo(Product::class,"product_id", "id");
    }

    public function parent():BelongsTo {
        return $this->belongsTo(Review::class,'parent_id',"id");
    }

    public function parentRecursion():BelongsTo {
        return $this->parent()->with('parentRecursion');
    }

    public function child():HasMany {
        return $this->hasMany(Review::class,'parent_id',"id");
    }

    public function childRecursion():HasMany {
        return $this->child()->with('childRecursion');
    }
}
