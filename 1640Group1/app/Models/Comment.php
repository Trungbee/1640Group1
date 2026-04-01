<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $primaryKey = 'commentId';
    protected $fillable = ['ideaId', 'userId', 'content', 'is_anonymous'];

    public function user() {
        return $this->belongsTo(User::class, 'userId');
    }
}
