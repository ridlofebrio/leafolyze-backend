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
        'user_id',
        'name',
        'address',
        'description',
        'operational',
        'gambarUrl',
    ];

    /**
     * Relation to User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
