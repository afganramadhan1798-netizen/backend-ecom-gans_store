<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'recipient',
    'phone',
    'province',
    'city',
    'district',
    'postal_code',
    'address_detail',
])]
class UserAddress extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
