<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'gambarUrl',
        'name',
        'shop_id',
        'description',
        'price',
        'type',
    ];

    /**
     * Relation to User.
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
