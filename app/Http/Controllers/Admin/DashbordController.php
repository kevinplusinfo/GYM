<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Trainer;
use App\Models\Customer\Customer;


class DashbordController extends Controller
{
    public function index(){
        $trainer = Trainer::count();
        $user = Customer::count();

        return view('Admin.Dashbord.Index',compact('trainer','user'));
    }

}
