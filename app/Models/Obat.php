<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Obat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'gambarUrl',
        'namaObat',
        'user_id',
        'deskripsi',
        'harga',
        'jenis',
    ];

    /**
     * Relation to User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
