<?php

namespace Modules\Roles\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolehasPermission extends Model
{
    use HasFactory;

    protected $fillable = ["role_id", "permission_id"];
    
    public function permissions():BelongsTo {
        return $this->belongsTo(Permission::class,"permission_id", "id");
    }
}
