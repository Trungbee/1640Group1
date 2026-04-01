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
        'title',
        'description',
        'filePath',
    ];

    public function user()
    {
        // Declare foreign keys and primary keys.
        return $this->belongsTo(User::class, 'userId', 'userId');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'categoryId');
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'ideaId', 'ideaId');
    }
    public function comments() {
        // Lấy danh sách comment, cái nào mới nhất xếp xuống dưới cùng
        return $this->hasMany(Comment::class, 'ideaId')->orderBy('created_at', 'asc');
    }
}
