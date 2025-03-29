<?php

namespace App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class SelectedPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_plan_id',
        'type',
        'plan_data',
    ];

    protected $casts = [
        'plan_data' => 'array',
    ];

    public function healthPlan()
    {
        return $this->belongsTo(HealthPlanExercise::class);
    }
}
