<?php

namespace Modules\Roles\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["name"];
    
    public function role_has_permissions():HasMany {
        return $this->hasMany(RolehasPermission::class,"role_id","id");
    }
}
