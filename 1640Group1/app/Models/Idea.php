<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;

    protected $primaryKey = 'ideaId';

    protected $fillable = [
        'userId',
        'categoryId',
        'title',       // Đã bổ sung
        'description', // Đã bổ sung
        'filePath',
    ];

    // 1. Định nghĩa mối quan hệ với bảng User (Một bài đăng thuộc về một người dùng)
    public function user()
    {
        // Khai báo rõ khóa ngoại và khóa chính để Laravel không bị nhầm lẫn
        return $this->belongsTo(User::class, 'userId', 'userId');
    }

    // 2. Định nghĩa mối quan hệ với bảng Category (Một bài đăng thuộc về một chuyên mục)
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'categoryId');
    }

    // 3. ĐÃ BỔ SUNG: Định nghĩa mối quan hệ với bảng Reaction (Lượt thích/không thích)
    public function reactions()
    {
        // 'ideaId' đầu tiên là cột khóa ngoại trong bảng reactions
        // 'ideaId' thứ hai là cột khóa chính trong bảng ideas
        return $this->hasMany(Reaction::class, 'ideaId', 'ideaId');
    }
}
