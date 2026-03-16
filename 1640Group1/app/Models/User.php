<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // 1. Khai báo khóa chính chính xác
    protected $primaryKey = 'userId';

    /**
     * Các thuộc tính có thể lưu hàng loạt (Mass Assignable).
     */
        protected $fillable = [
        'username',
        'fullName',      // <--- Bổ sung fullname
        'email',
        'passwordHash',
        'role',
        'acceptTerms',
        'isActive',
        'favorite_animal',
        'favorite_color',
        'child_birth_year',
        ];

    /**
     * Các thuộc tính nên ẩn khi xuất dữ liệu (Serialization).
     */
    protected $hidden = [
        'passwordHash',
        'remember_token',
        'favorite_animal',
        'favorite_color',
        'child_birth_year',
    ];

    /**
     * Ép kiểu dữ liệu (Casts).
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'passwordHash' => 'hashed',
            'acceptTerms' => 'boolean',
            'isActive' => 'boolean',
        ];
    }

    // 2. Định nghĩa quan hệ: Một người dùng có thể có nhiều bài đăng (Ideas)
    public function ideas()
    {
        return $this->hasMany(Idea::class, 'userId', 'userId');
    }

    // 3. Giúp chức năng Đăng nhập của Laravel tìm đúng cột mật khẩu thay vì cột 'password' mặc định
    public function getAuthPassword()
    {
        return $this->passwordHash;
    }
}
