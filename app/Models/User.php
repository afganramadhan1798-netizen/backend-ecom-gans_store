<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'name',
    'username',
    'email',
    'password',
    'role',
    'is_active',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
        public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

        public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

        public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function address(): HasOne
    {
    return $this->hasOne(UserAddress::class);
    }
}
