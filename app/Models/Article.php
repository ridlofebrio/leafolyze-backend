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
        'title',
        'content',
        'duration',
    ];

    protected static function boot()
    {
        parent::boot();

        // Set user_id automatically when creating an article
        static::creating(function ($article) {
            if (!$article->user_id) {
                $article->user_id = auth()->id();
            }
        });
    }

    /**
     * Relation to Image.
     */
    public function image()
    {
        return $this->hasOne(Image::class, 'article_id');
    }
}
