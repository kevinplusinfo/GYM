<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $table = 'trainers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'experience',
        'expertise',
        'remark',
        'image'
    ];
}
