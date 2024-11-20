<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TomatoLeafDetection extends Model
{
    use HasFactory;

    protected $fillable = [
        'gambarUrl',
        'user_id',
        'description',
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
}
