<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'judul',
        'konten',
        'gambar',
        'durasi_baca',
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
