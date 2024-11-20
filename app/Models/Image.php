<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';
    protected $primaryKey = 'id';

    protected $guarded = [
        'id'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    public function userDetail(): BelongsTo
    {
        return $this->belongsTo(UserDetail::class, 'user_detail_id', 'id');
    }

    public function tomatoLeafDetection(): BelongsTo
    {
        return $this->belongsTo(TomatoLeafDetection::class, 'tomato_leaf_detection_id', 'id');
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}