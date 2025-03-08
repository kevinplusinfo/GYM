<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PlanFeature;
use App\Models\Admin\Plan;
use App\Models\Admin\AddedPlanFeatures;


use Illuminate\Http\Request;

class AdminPlanController extends Controller
{
    public function plan()
    {
        $plans = Plan::all();
        $planFeatures = AddedPlanFeatures::with('feature')
            ->get()
            ->groupBy('plan_id')
            ->map(function ($features) {
                return $features->map(function ($addedFeature) {
                    return $addedFeature->feature; 
                });
            });
        return view('Admin.Plan.Plan', compact('plans', 'planFeatures'));
    }


    
    public function form($id = null)
    {
        if ($id) {
            $plan = Plan::find($id);
            if (!$plan) {
                return redirect()->route('admin.plans.index')->with('error', 'Plan not found');
            }

            $feature_lists = PlanFeature::select('id', 'name')->get();
            $addedPlanFeatures = AddedPlanFeatures::where('plan_id', $id)
                                                  ->pluck('feature_id');

            $features = PlanFeature::whereIn('id', $addedPlanFeatures)->get();
            return view('Admin.Plan.Add', compact('plan', 'features', 'feature_lists'));
        }
        $planfeature = PlanFeature::all();
        return view('Admin.Plan.Add', ['feature_lists' => $planfeature]);
    }
    
    public function add(Request $request, $id = null)
    {
        // Check if this is an update or a new plan
        if ($id) {
            $plan = Plan::find($id);
            if (!$plan) {
                return redirect()->route('plan.plan')->with('alert_error', 'Plan not found!');
            }
            $msg = "Plan Updated Successfully...";
        } else {
            $plan = new Plan;
            $msg = "Plan Added Successfully...";
        }
    
        // Save or update plan details
        $plan->name = $request->input('plan_name');
        $plan->description = $request->input('plan_description');
        $plan->duration = $request->input('plan_duration');
        $plan->price = $request->input('plan_price');
        $plan->payment_type = $request->input('payment_type');
        $plan->status = $request->has('active') ? 'Active' : 'Inactive';
        $plan->save();
    
        // Handle features specific to this plan
        if ($request->has('features')) {
            $submittedFeatures = $request->input('features'); // Get submitted features
        } else {
            $submittedFeatures = []; // Default to empty if none provided
        }
    
        // Remove existing features for this plan ID
        AddedPlanFeatures::where('plan_id', $plan->id)->delete();
    
        // Add the submitted features for the current plan
        foreach ($submittedFeatures as $featureId) {
            AddedPlanFeatures::create([
                'plan_id' => $plan->id,
                'feature_id' => $featureId,
            ]);
        }
    
        return redirect()->route('plan.plan')->with('alert_success', $msg);
    }
    
    

    public function delete($id)
    {
        $plan = Plan::find($id);
        if (!$plan) {
            return redirect()->route('Admin.Plan.Plan')->with('error', 'Plan not found');
        }
        AddedPlanFeatures::where('plan_id', $id)->delete();
        $plan->delete();
        return redirect()->route('plan.plan')->with('success', 'Plan and its Features Deleted Successfully');
    }

}
