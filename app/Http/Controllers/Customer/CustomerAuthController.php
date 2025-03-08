<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('customer.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validate credentials
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.login')->withErrors($validator)->withInput();
        }

        // Check if the user is a customer
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'customer') {
                return redirect()->route('customer.dashboard'); // Redirect to customer dashboard
            }

            Auth::logout();
        }

        return redirect()->route('customer.login')->withErrors(['email' => 'Invalid credentials or not a customer']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('customer.login');
    }
}
