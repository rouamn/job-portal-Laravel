<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject // Implementing the interface
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // This method returns the user identifier to be included in the JWT.
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Typically, it's the user's primary key (ID)
    }

    // This method returns any custom claims for the JWT.
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function jobListings()
    {
        return $this->hasMany(JobListing::class);
    }
}
