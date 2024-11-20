<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'disease_id',
    ];

    /**
     * Relation to User.
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    /**
     * Relation to Disease.
     */
    public function disease()
    {
        return $this->belongsTo(Disease::class, 'disease_id');
    }
}
