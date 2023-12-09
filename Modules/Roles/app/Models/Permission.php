<?php

namespace Modules\Roles\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ["name"];
    
    public function user():BelongsTo {
        return $this->belongsTo(User::class,"user_id", "id");
    }
}
