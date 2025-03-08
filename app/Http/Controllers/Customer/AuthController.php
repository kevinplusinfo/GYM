<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Show Register Form
    public function showRegisterForm()
    {
        return view('Customer.Auth.Register');
    }

    // Handle User Registration
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users', // Use 'users' instead of 'customers'
        'mno' => 'required|string|max:10|min:10|unique:users',
        'password' => 'required|string|confirmed|min:5',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = Customer::create([  // Customer model is mapped to 'users' table
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);


    return redirect()->route('index.gallery');
}

    // Show Login Form
    public function showLoginForm()
    {
        return view('Customer.Auth.Login');
    }

    // Handle User Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('index.gallery');
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }
    

    // Handle Logout
    public function logout(Request $request)
    {
        Auth::guard('user')->logout(); 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('clogin');
    }
}
