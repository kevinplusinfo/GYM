<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\Appointment;  

class AdminAppointmentController extends Controller
{
    public function index() {
        $appointments = Appointment::all();
        return view('Admin.Appointment.appointment', compact('appointments'));
    }
}
