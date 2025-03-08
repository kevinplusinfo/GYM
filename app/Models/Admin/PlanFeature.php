<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PlanFeature extends Model
{
    protected $table = 'planfeatures';
    protected $fillable = ['name'];
    public function plans()
{
    return $this->hasMany(AddedPlanFeatures::class, 'feature_id', 'id');

}
}
