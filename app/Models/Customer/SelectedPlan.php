<?php

namespace App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class SelectedPlan extends Model
{
    use HasFactory;
    protected $table = 'selected_plans';

    protected $fillable = [
        'health_plan_id',
        'plan_no',
        'ischeck',
    ];

   
    public function healthPlanExercise()
    {
        return $this->belongsTo(HealthPlanExercise::class, 'health_plan_id', 'id');
    }
}
