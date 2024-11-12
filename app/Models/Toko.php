<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Toko extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'nama_toko',
        'alamat',
        'deskripsi',
        'jam_operasional',
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
