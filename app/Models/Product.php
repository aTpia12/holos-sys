<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'cant',
        'name',
        'slug',
        'price',
        'description',
        'image',
        'code',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
