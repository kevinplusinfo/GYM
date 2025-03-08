<?php

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class AddedPlanFeatures extends Model
{
    protected $table = 'added_plan_features';
    protected $fillable = ['plan_id', 'feature_id'];
    public function feature()
    {
        return $this->belongsTo(PlanFeature::class, 'feature_id', 'id');
    }


}
