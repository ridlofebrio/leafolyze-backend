<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $table = 'shops';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'noHp',
        'description',
        'operational',
    ];

    /**
     * Relation to User.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Relation to Product.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Relation to Image.
     */
    public function image()
    {
        return $this->hasOne(Image::class, 'shop_id');
    }
}
