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
        'gambarUrlObat',
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

    protected function gambarUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => url('/storage/gambar/' . $value),
        );
    }
}
