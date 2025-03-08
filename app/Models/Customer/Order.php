<?php

namespace App\Models\Customer; 
use App\Models\Customer\Customer; 
use App\Models\Admin\Plan;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 'plan_id', 'amount', 'razorpay_order_id', 'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id'); 
    }
   
}
