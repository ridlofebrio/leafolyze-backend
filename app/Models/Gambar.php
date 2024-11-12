<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Gambar extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'gambar';

    protected $fillable = [
        'gambarUrl',
        'user_id',
        'deskripsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
