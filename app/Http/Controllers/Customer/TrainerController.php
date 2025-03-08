<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Trainer;

class TrainerController extends Controller
{
    public function index(){
        $trainers = Trainer::all();
        // dd($trainers);
        return view('Customer.Trainer.Index', compact('trainers'));
    }

}
