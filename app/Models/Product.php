<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'shop_id',
        'description',
        'price',
        'disease_id',
    ];

    /**
     * Relation to Shop.
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

    /**
     * Relation to Image.
     */
    public function image()
    {
        return $this->hasMany(Image::class, 'product_id');
    }
}