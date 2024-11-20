<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TomatoLeafDetection extends Model
{
    use HasFactory;

    protected $table = 'tomato_leaf_detections';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'title',
    ];

    /**
     * Get the user that owns the detection.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all diseases detected in this detection.
     */
    public function diseases()
    {
        return $this->belongsToMany(Disease::class, 'detection_disease', 'detection_id', 'disease_id')
            ->withTimestamps();
    }

    /**
     * Relation to Image.
     */
    public function image()
    {
        return $this->hasOne(Image::class, 'tomato_leaf_detection_id');
    }
}
