<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\Customer;

class UserController extends Controller
{
    public function index(){
        $user = Customer::get();
        return view('Admin.User.Index',compact('user'));
    }
}
