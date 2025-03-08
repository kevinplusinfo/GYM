<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'class';
    protected $fillable = ['title', 'img', 'description', 'status'];
}
