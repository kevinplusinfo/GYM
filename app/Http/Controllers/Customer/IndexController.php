<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Setting;  
use App\Models\Admin\Classes;  
use App\Models\Admin\PlanFeature;
use App\Models\Admin\Plan;
use App\Models\Admin\AddedPlanFeatures;
use App\Models\Admin\Gallery;  
use App\Models\Admin\Trainer;
use App\Models\Customer\ProductCart;
use Illuminate\Support\Facades\Auth;




class IndexController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        $class = Classes::all();
        $plans = Plan::where('status', 'Active')->get();
        $planFeatures = AddedPlanFeatures::with('feature')
            ->get()
            ->groupBy('plan_id')
            ->map(function ($features) {
                return $features->map(function ($addedFeature) {
                    return $addedFeature->feature; 
                });
            });
            $images = Gallery::all();
            $trainers = Trainer::all();
            $totalQty = ProductCart::where('customer_id', Auth::id())->sum('qty');
            // dd($totalQty);



        return view('Customer.Index.Index', compact('setting','class','plans', 'planFeatures','images','trainers','totalQty'));
    }
}
