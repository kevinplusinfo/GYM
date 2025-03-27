<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Trainer;
use App\Models\Customer\Customer;
use App\Models\Customer\Product_order;
use App\Models\Customer\ProductCart;




class DashbordController extends Controller
{
    public function index(){
        $trainer = Trainer::count();
        $order = Product_order::count();
        $cart_qty = ProductCart::sum('qty');
        $user = Customer::count();

        return view('Admin.Dashbord.Index',compact('trainer','order','cart_qty','user'));
    }

}
