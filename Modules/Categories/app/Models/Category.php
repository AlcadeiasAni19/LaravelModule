<?php

namespace Modules\Categories\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Categories\Database\factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["name", "is_set", "user_id"];

    public function user():BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
}
