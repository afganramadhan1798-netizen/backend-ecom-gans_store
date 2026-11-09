<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'category_id',
    'name',
    'variant',
    'price',
    'image',
    'bestseller',
    'stock',
    'description',
    'is_active',
])]
class Product extends Model
{
    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'bestseller' => 'boolean',
            'stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function wishlists(): HasMany
    {
    return $this->hasMany(Wishlist::class);
    }
}
