<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'userId';

        protected $fillable = [
        'username',
        'fullName',
        'email',
        'passwordHash',
        'role',
        'acceptTerms',
        'isActive',
        'favorite_animal',
        'favorite_color',
        'child_birth_year',
        ];

    protected $hidden = [
        'passwordHash',
        'remember_token',
        'favorite_animal',
        'favorite_color',
        'child_birth_year',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'passwordHash' => 'hashed',
            'acceptTerms' => 'boolean',
            'isActive' => 'boolean',
        ];
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class, 'userId', 'userId');
    }

    public function getAuthPassword()
    {
        return $this->passwordHash;
    }
}
