<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Modules\Carts\app\Models\Cart;
use Modules\Roles\app\Models\Role;
use Illuminate\Notifications\Notifiable;
use Modules\Products\app\Models\Product;
use Modules\Products\app\Models\Wishlist;
use Modules\Categories\app\Models\Category;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'balance'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function cart():HasMany {
        return $this->hasMany(Cart::class,"user_id","id");
    }

    public function category():HasMany {
        return $this->hasMany(Category::class,"user_id","id");
    }

    public function userHasRole():HasOne {
        return $this->hasOne(Role::class, "id", "role");
    }

    public function product():HasMany {
        return $this->hasMany(Product::class);
    }

    public function wishlist():HasOne {
        return $this->hasOne(Wishlist::class, "user_id", "id");
    }
}
