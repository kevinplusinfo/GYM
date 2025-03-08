<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Classes;  


class ClassController extends Controller
{
    public function class(){
        $class = Classes::where('status', 'Active')->get();
        // dd($class);
        return view('Customer.Class.Class', ['class' => $class]);
    }

    public function detail($id){
        $class = Classes::find($id);
        $classesWithSameTitle = Classes::where('title', 'LIKE', '%' . $class->title . '%')
                                  ->where('id', '!=', $id) // Exclude the original record
                                  ->get();

        return view('Customer.Class.Detail',compact('class', 'classesWithSameTitle'));
    }

}
