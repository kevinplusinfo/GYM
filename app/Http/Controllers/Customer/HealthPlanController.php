<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\HealthPlanExercise;
use App\Models\Customer\SelectedPlan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class HealthPlanController extends Controller
{
    public function index()
    {
        return view('Customer.Health.form');
    }

    public function generatePlan(Request $request)
    {
        $request->validate([
            'goal' => 'required|string',
            'current_weight' => 'required|numeric',
            'height' => 'required|numeric',
            'age' => 'required|numeric',
            'activity_level' => 'required|string',
            'dietary_pref' => 'required|string',
        ]);
    
        $apiKey = config('services.google_ai.key');
        if (!$apiKey) {
            return response()->json(['error' => 'API key is missing.'], 500);
        }
    
        $prompt = "Generate 3 structured diet and workout plans with meal timings for:
        - Goal: {$request->goal}
        - Weight: {$request->current_weight} kg
        - Height: {$request->height} cm
        - Age: {$request->age}
        - Activity Level: {$request->activity_level}
        - Dietary Preference: {$request->dietary_pref}
    
        The diet plan should include meals with specific timings: breakfast, lunch, dinner, and snacks.
        
        Format response as JSON only, no explanations:
        {
            \"plans\": {
                \"plan_1\": {
                    \"exercise\": {
                        \"monday\": \"Workout details...\",
                        \"tuesday\": \"Workout details...\"
                    },
                    \"diet\": {
                        \"breakfast\": \"Oatmeal with fruits\",
                        \"lunch\": \"Grilled chicken with veggies\",
                        \"snacks\": \"Mixed nuts\",
                        \"dinner\": \"Salmon with quinoa\"
                    }
                },
                \"plan_2\": {
                    \"exercise\": {
                        \"monday\": \"Workout details...\",
                        \"tuesday\": \"Workout details...\"
                    },
                    \"diet\": {
                        \"breakfast\": \"Egg whites with avocado\",
                        \"lunch\": \"Brown rice with tofu\",
                        \"snacks\": \"Greek yogurt\",
                        \"dinner\": \"Grilled fish with broccoli\"
                    }
                },
                \"plan_3\": {
                    \"exercise\": {
                        \"monday\": \"Workout details...\",
                        \"tuesday\": \"Workout details...\"
                    },
                    \"diet\": {
                        \"breakfast\": \"Smoothie with spinach and banana\",
                        \"lunch\": \"Quinoa salad with beans\",
                        \"snacks\": \"Hummus with carrots\",
                        \"dinner\": \"Lentil soup with whole wheat bread\"
                    }
                }
            }
        }";
    
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->withOptions([
                'verify' => false  
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro-latest:generateContent?key=$apiKey", [
                'contents' => [['role' => 'user', 'parts' => [['text' => $prompt]]]]
            ]);
    
            Log::info('AI API Response:', ['body' => $response->body()]);
    
            $aiData = $response->json();
    
            if (!isset($aiData['candidates'][0]['content']['parts'][0]['text'])) {
                return back()->withErrors([
                    'error' => 'Invalid response from AI API',
                    'api_response' => $aiData
                ]);
            }
    
            $plansText = $aiData['candidates'][0]['content']['parts'][0]['text'];
    
            // Clean JSON response if wrapped in code block
            $cleanJson = preg_replace('/^```json\n|\n```$/', '', trim($plansText));
            $plans = json_decode($cleanJson, true);
    
            if (!$plans || !isset($plans['plans'])) {
                return back()->withErrors([
                    'error' => 'Invalid AI-generated response format',
                    'api_response' => $cleanJson
                ]);
            }
    
            $plan = HealthPlanExercise::create([
                'user_id' => Auth::id(),
                'goal' => $request->goal,
                'current_weight' => $request->current_weight,
                'height' => $request->height,
                'age' => $request->age,
                'activity_level' => $request->activity_level,
                'dietary_pref' => $request->dietary_pref,
                'plans' => json_encode($plans['plans']),
            ]);
    
            return redirect()->route('plans.show', $plan->id)->with('success', 'Three plans generated successfully!');
    
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Failed to connect to AI API',
                'exception' => $e->getMessage()
            ]);
        }
    }
    
    
    public function selectPlan(Request $request)
    {
        $request->validate([
            'plan_number' => 'required|integer|min:1|max:3',
            'plan_id' => 'required|integer|exists:health_plan_exercises,id',
        ]);

        $healthPlan = HealthPlanExercise::findOrFail($request->plan_id);
        $plans = json_decode($healthPlan->plans, true);
        $selectedPlanData = $plans["plan_{$request->plan_number}"];

        SelectedPlan::create([
            'health_plan_id' => $healthPlan->id,
            'type' => 1,
            'plan_data' => json_encode($selectedPlanData['exercise']),
        ]);

        SelectedPlan::create([
            'health_plan_id' => $healthPlan->id,
            'type' => 2, 
            'plan_data' => json_encode($selectedPlanData['diet']),
        ]);

        $healthPlan->update(['is_selected' => 1]);
        return redirect()->route('show.selected.plan')->with('success', "You have selected Plan {$request->plan_number}.");
    }

    public function show($id)
    {
        $plan = HealthPlanExercise::findOrFail($id);

        $plan->plans = json_decode($plan->plans, true);

            return view('Customer.Health.show-plans', compact('plan'));
        }
    
}
