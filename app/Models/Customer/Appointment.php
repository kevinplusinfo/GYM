<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'class',
        'appointment_date',
        'appointment_time',
        'remark'
    ];
}
