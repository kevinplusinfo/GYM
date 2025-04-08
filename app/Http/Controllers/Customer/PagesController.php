<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\Contact;  
use App\Models\Customer\Feedback;  
use App\Models\Admin\Trainer;  
use App\Models\Admin\PlanFeature;
use App\Models\Admin\Plan;
use App\Models\Admin\AddedPlanFeatures;
use App\Models\Admin\Classes;  




class PagesController extends Controller
{
    public function contact(){
        return view('Customer.Contact-as');
    }
    public function addcontact(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contact_as,email|max:255',
            'website' => 'nullable|string|max:255',
            'comment' => 'required|string',
        ]);
    
        Contact::create($validated);
    
        return redirect()->back()->with('success', 'Contact information added successfully!');
    }
    public function about(){
        $feedbacks = Feedback::with('user')->latest()->get();
        $trainers = Trainer::all();

        return view('Customer.About-as', compact('feedbacks','trainers'));
    }

    public function services(){
        $plans = Plan::where('status', 'Active')->get();
        $planFeatures = AddedPlanFeatures::with('feature')
            ->get()
            ->groupBy('plan_id')
            ->map(function ($features) {
                return $features->map(function ($addedFeature) {
                    return $addedFeature->feature; 
                });
            });
            $classes = Classes::limit(4)->get();

        return view('Customer.Services.Services',compact('plans', 'planFeatures','classes'));
    }

    public function timetable(){
        return view('Customer.TimeTable');
    }
    
}
