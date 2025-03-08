<?php

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;
use Laravel\Prompts\Table;

class Blog extends Model
{
    protected $table = 'blog';
    protected $fillable = ['title', 'img', 'description', 'status'];
    public function tags()
    {
        return $this->hasMany(Tags::class); 
    }
}
