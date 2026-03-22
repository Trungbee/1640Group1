<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    // Cấp quyền cho phép lưu các cột này vào Database
    protected $fillable = ['ideaId', 'userId', 'is_upvote'];
}
