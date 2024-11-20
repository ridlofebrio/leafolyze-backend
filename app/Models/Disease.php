<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get all detections that have this disease.
     */
    public function detections()
    {
        return $this->belongsToMany(TomatoLeafDetection::class, 'detection_disease', 'disease_id', 'detection_id')
            ->withTimestamps();
    }

    /**
     * Relation to Product.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'disease_id');
    }
}
