<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact_as';
    protected $fillable = ['name', 'email', 'website', 'comment'];
}
