<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PlanFeature;
use App\Models\Admin\Plan;
use App\Models\Admin\AddedPlanFeatures;
use App\Models\Customer\Order;


class PurchasePlanController extends Controller
{
    public function index()
{
    $query = Plan::query();

    if ($searchTerm = request()->get('name')) {
        $query->where('name', 'like', '%' . $searchTerm . '%');
    }

    if ($price = request()->get('price')) {
        $query->where('price', 'like', '%' . $price . '%');
    }

    if ($duration = request()->get('duration')) {
        $query->where('duration', 'like', '%' . $duration . '%');
    }

    $plans = $query->whereHas('orders')
                   ->with(['feature.feature'])
                   ->get();

    return view('Admin.PurchasePlan.index', compact('plans'));
}


    
}
