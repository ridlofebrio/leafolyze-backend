<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Shop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'gambarUrl',
        'name',
        'toko_id',
        'description',
        'price',
        'type',
    ];

    /**
     * Relation to User.
     */
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }
}
