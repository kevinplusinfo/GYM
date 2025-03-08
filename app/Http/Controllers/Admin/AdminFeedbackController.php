<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\Feedback;  

class AdminFeedbackController extends Controller
{
    public function index(){
        $feedbacks = Feedback::with('user')->latest()->get();

        return view('Admin.Feedback.Feedback', compact('feedbacks'));
    }
}
