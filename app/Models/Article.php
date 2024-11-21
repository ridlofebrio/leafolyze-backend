<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'duration',
    ];

    /**
     * Relation to Image.
     */
    public function image()
    {
        return $this->hasOne(Image::class, 'articles_id');
    }
}
