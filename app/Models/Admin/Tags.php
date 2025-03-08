<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = 'tags';
    protected $fillable = [
        'tags' , 'blog_id'
    ];
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
