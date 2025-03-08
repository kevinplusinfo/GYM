<?php
namespace App\Http\Controllers\admin;

use App\Http\Models\Admin\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
// $hashedPassword = Hash::make(96380);
// dd($hashedPassword);
class AdminAuthController extends Controller
{
    public function authenticate(Request $request): RedirectResponse
    {    
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'] 
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            
            $msg = "Login Successfully...";
            return redirect()->route('dashbord')->with('alert_success', $msg);
            
        }
        
        return back()->withErrors([
            'email' => 'The Provided Credentials Do Not Match Our Records.',
        ])->onlyInput('email'); 
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login-view')->with('alert_success', 'Successfully logged out.');
    }
}
