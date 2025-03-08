<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['user_id', 'description', 'suggestion', 'rating', 'img'];

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id', 'id');
    }
}
