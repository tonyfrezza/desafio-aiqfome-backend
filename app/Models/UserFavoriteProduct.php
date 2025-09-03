<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavoriteProduct extends Model
{
    protected $table = 'users_favorites_products';

    protected $fillable = [
        'users_id',
        'products',
    ];

    protected $casts = [
        'products' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
