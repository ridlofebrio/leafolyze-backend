<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, FilamentUser
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'email',
        'password',
        'access',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relation to UserDetail.
     */
    public function userDetail()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    /**
     * Relation to Shop.
     */
    public function shop()
    {
        return $this->hasOne(Shop::class, 'user_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'iss' => config('app.url'),
            'iat' => time(),
            'nbf' => time(),
            'sub' => $this->id,
            'role' => $this->role
        ];
    }

    /**
     * Get all detections belonging to the user.
     */
    public function detections()
    {
        return $this->hasMany(TomatoLeafDetection::class);
    }

    // Add this method to get the name from UserDetail
    public function getName(): string
    {
        return $this->userDetail?->name ?? $this->email;
    }

    public function getNameAttribute()
    {
        return $this->userDetail?->name ?? $this->email;
    }

    // Add this method for Filament
    public function getFilamentName(): string
    {
        return $this->userDetail?->name ?? $this->email;
    }

    public function canAccessPanel(Panel $panel): bool
    {
       return in_array($this->access, ['admin', 'penjual']);
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

}
