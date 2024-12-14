<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'subtotal',
        'iva',
        'total',
        'cart',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
