<?php

namespace App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class HealthPlanExercise extends Model
{
    use HasFactory;
    protected $table = 'health_plans_exercise';

    protected $fillable = [
        'user_id',
        'goal',
        'current_weight',
        'height',
        'age',
        'activity_level',
        'dietary_pref',
        'plans',
        'is_selected',
    ];

    protected $casts = [
        'plans' => 'array',
    ];

    public function selectedPlans()
    {
        return $this->hasMany(SelectedPlan::class);
    }
}
