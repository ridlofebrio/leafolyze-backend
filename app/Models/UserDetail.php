<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'user_details';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'name',
        'birth',
        'gender',
        'address',
    ];

    protected $casts = [
        'birth' => 'date',
    ];

    /**
     * Relation to User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    /**
     * Relation to Detection.
     */
    public function detections()
    {
        return $this->hasMany(TomatoLeafDetection::class);
    }

    /**
     * Relation to Image.
     */
    public function image()
    {
        return $this->hasOne(Image::class, 'user_detail_id');
    }
}
