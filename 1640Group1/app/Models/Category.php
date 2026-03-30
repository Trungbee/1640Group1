<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'categoryId'; //Declare the primary key.

    protected $fillable = ['name'];
}
