<?php

namespace Modules\Carts\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Carts\Database\factories\TransactionFactory;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["user_id", "order_id", "payment", "balance"];  

    public function order():BelongsTo {
        return $this->belongsTo(Order::class);
    }
}
