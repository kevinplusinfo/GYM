<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\Appointment;  


class AppointmentController extends Controller
{
    public function Appointment(){
        return view('Customer.Appointment.Appointment');
    }
    public function store(Request $request)
    {
        $request->validate([
            
            'appointment_date' => 'required|date|after_or_equal:today',
          
        ], [
            'appointment_date.after_or_equal' => 'The appointment date must be today or a future date.',
        ]);

        Appointment::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'class' => $request->session_type,
            'appointment_date' => $request->appointment_date,  
            'appointment_time' => $request->appointment_time,
            'remark' => $request->remark,
        ]);

        return redirect()->back()->with('success', 'Your appointment has been booked!');
    }

}
