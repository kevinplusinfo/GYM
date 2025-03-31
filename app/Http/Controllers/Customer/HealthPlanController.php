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
        $validatedData = $request->validate([
            'goal' => 'required|string',
            'current_weight' => 'required|numeric',
            'height' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'age' => 'required|numeric',
            'activity_level' => 'required|string',
            'work' => 'required|string',
            'dailyroutin' => 'nullable|string',
        ]);

        $apiKey = config('services.google_ai.key');
        if (!$apiKey) {
            return back()->withErrors(['error' => 'API key is missing.']);
        }

        $prompt = "Generate three structured weekly workout and diet plans for a user with these details:
        - **Goal:** {$validatedData['goal']}
        - **Weight:** {$validatedData['current_weight']} kg
        - **Height:** {$validatedData['height']} cm
        - **Age:** {$validatedData['age']}
        - **Activity Level:** {$validatedData['activity_level']}
        - **Work Type:** {$validatedData['work']}
        - **Daily Routine:** {$validatedData['dailyroutin']}

        **Each day's plan must include:**
        - **Warm-up (5-10 minutes)**
        - **Main Workout (Strength, Cardio, Endurance based on goal)**
        - **Cool-down (Stretching/Yoga)**
        
        **Ensure the response is strictly valid JSON (no markdown, no additional text) like this:**
        {
            \"plans\": {
                \"plan1\": {
                    \"exercise\": {
                        \"monday\": {
                            \"warm_up\": \"5-minute jumping jacks\",
                            \"primary\": \"30-minute full-body strength training\",
                            \"cool_down\": \"10-minute stretching\"
                        },
                        \"tuesday\": { ... },
                        ...
                    },
                    \"diet\": {
                        \"monday\": { \"breakfast\": \"Oatmeal with fruit\", \"lunch\": \"Grilled chicken with quinoa\", \"dinner\": \"Salmon with roasted vegetables\" },
                        \"tuesday\": { ... }
                    }
                },
                \"plan2\": { \"exercise\": { ... }, \"diet\": { ... } },
                \"plan3\": { \"exercise\": { ... }, \"diet\": { ... } }
            }
        }";

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->withOptions(['verify' => false])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro-latest:generateContent?key=$apiKey", [
                    'contents' => [['role' => 'user', 'parts' => [['text' => $prompt]]]]
                ]);

            Log::info('AI API Response:', ['body' => $response->body()]);

            if (!$response->successful()) {
                return back()->withErrors(['error' => 'AI API request failed', 'response' => $response->body()]);
            }

            $aiData = $response->json();

            if (!isset($aiData['candidates'][0]['content']['parts'][0]['text'])) {
                return back()->withErrors(['error' => 'Invalid AI response', 'api_response' => json_encode($aiData)]);
            }

            $plansText = $aiData['candidates'][0]['content']['parts'][0]['text'];
            $cleanJson = trim(preg_replace('/^```json\n|\n```$/', '', $plansText));

            $plans = json_decode($cleanJson, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON Decode Error:', ['error' => json_last_error_msg(), 'response' => $cleanJson]);
                return back()->withErrors(['error' => 'AI response is not valid JSON', 'api_response' => $cleanJson]);
            }

            if (!isset($plans['plans']['plan1']) || !isset($plans['plans']['plan2']) || !isset($plans['plans']['plan3'])) {
                Log::error('AI response missing plans:', ['response' => $cleanJson]);
                return back()->withErrors(['error' => 'AI response does not contain all required plans', 'api_response' => $cleanJson]);
            }

            $userId = Auth::id();
            if (!$userId) {
                return back()->withErrors(['error' => 'User not authenticated']);
            }

            $plan = HealthPlanExercise::create([
                'user_id' => $userId,
                'goal' => $validatedData['goal'],
                'current_weight' => $validatedData['current_weight'],
                'height' => $validatedData['height'],
                'age' => $validatedData['age'],
                'activity_level' => $validatedData['activity_level'],
                'work' => $validatedData['work'],
                'dailyroutin' => $validatedData['dailyroutin'],
                'plans' => json_encode($plans['plans']), 
            ]);

            return redirect()->route('plans.show', $plan->id)->with('success', 'Three workout plans generated successfully!');

        } catch (\Exception $e) {
            Log::error('API Request Error:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to connect to AI API', 'exception' => $e->getMessage()]);
        }
    }
    
    public function selectPlan(Request $request)
    {
    
        $selectedPlan = new SelectedPlan();
        $selectedPlan->user_id = Auth::id();
        $selectedPlan->health_plan_id = $request->plan_id;
        $selectedPlan->plan_no = $request->plan_no;
        $selectedPlan->ischeck = $request->has('ischeck') ? 1 : 0;
        $selectedPlan->save();
    
        return redirect()->route('show.selected.plan')->with('success', "You have successfully selected Plan {$request->plan_no}.");
    }
    
    public function show($id)
    {
        $plan = HealthPlanExercise::findOrFail($id);
        $plans = json_decode($plan->plans, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON Decode Error:', ['error' => json_last_error_msg()]);
            return back()->withErrors(['error' => 'Failed to load health plan.']);
        }

        return view('Customer.Health.show-plans', compact('plan', 'plans'));
    }

    public function showSelectedPlans()
{
    $selectedPlans = SelectedPlan::where('user_id', Auth::id())->get()->map(function ($plan) {
        $healthPlan = HealthPlanExercise::find($plan->health_plan_id);
        $plans = $healthPlan ? json_decode($healthPlan->plans, true) : [];

        return [
            'plan_no' => $plan->plan_no,
            'exercise' => $plans[$plan->plan_no]['exercise'] ?? [],
            'diet' => $plans[$plan->plan_no]['diet'] ?? [],
        ];
    });
    // dd($selectedPlans);
        return view('Customer.Health.selected-plans', compact('selectedPlans'));
    }
    
}
