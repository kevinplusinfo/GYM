<?php

namespace App\Models\Admin; 
use App\Models\Customer\Order; 
use App\Models\Admin\AddedPlanFeatures;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';
    protected $fillable = [
        'name' , 'description','duration','price','payment_type','status'
    ];
    public function feature()
    {
        return $this->hasMany(AddedPlanFeatures::class, 'plan_id', 'id');
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'plan_id');
    }
}
