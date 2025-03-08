<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model {
    use HasFactory;
    protected $table = 'settings';


    protected $fillable = [
        'img1', 'img2', 'icon', 'addresh', 'mno1', 'mno2', 'email', 
        'facebook_link', 'twitter_link', 'youtube_link', 'instagram_link', 
        'gmail_link', 'footerdescription'
    ];
}
