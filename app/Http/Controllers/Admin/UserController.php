<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\Customer;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $user = $query->get(); 

        return view('Admin.User.Index', compact('user'));
    }

}
