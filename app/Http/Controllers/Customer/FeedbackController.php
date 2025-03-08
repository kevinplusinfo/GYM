<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('Customer.Feedback');
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        if (Feedback::where('user_id', $userId)->exists()) {
            return back()->with('error', 'You have already submitted feedback.');
        }

        $request->validate([
            'description' => 'required|string|max:191',
            'suggestion' => 'nullable|string|max:191',
            'rating' => 'required|in:1,2,3,4,5',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->hasFile('img') ? $request->file('img')->store('feedback_images', 'public') : null;

        Feedback::create([
            'user_id' => $userId,
            'description' => $request->description,
            'suggestion' => $request->suggestion,
            'rating' => $request->rating,
            'img' => $imagePath,
        ]);

        return back()->with('success', 'Feedback submitted successfully!');
    }
}
