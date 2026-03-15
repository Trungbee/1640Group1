<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    protected $primaryKey = 'userId';
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'fullName',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
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
            'passwordHash' => 'hashed', // Tự động mã hóa Hash cho cột passwordHash
            'acceptTerms' => 'boolean',
            'isActive' => 'boolean',
        ];
    }

    // 4. Hàm BẮT BUỘC: Giúp chức năng Đăng nhập của Laravel tìm đúng cột mật khẩu
    public function getAuthPassword()
    {
        return $this->passwordHash;
    }
}
