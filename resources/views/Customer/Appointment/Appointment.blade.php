@extends('Customer.layout.main') <!-- Extend from the layout file -->
@section('title') Appointment @endsection <!-- Page Title -->

@section('styles')
<link href="{{asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
<style>
    .error { color: red; font-weight: normal!important; }
    .badge { font-size: 15px; cursor: pointer; }
    th, td { text-align: center; }
    .form-control { background-color: #151515; color: white; }
    .profile-card { background-color: #222; color: white; padding: 20px; border-radius: 10px; text-align: center; }
</style>
@endsection

@section('content')
<section class="classes-section spad">
    <div class="col-lg-8 text-center" style="margin-left:16%">
        <div class="leave-comment mt-5," style="margin-top:100px;">
            <h2 style="color:white" class="mt-5">Book Your Gym Appointment</h2>
            <p class="mt-2" style="margin-bottom: 50px;color:#f36100">Fill in the details below to schedule your session.</p>
            <form action="{{route('appointment.store')}}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Full Name" required class="form-control" style="background-color: #151515;color:white">
                <input type="email" name="email" placeholder="Email Address" class="form-control" required style="background-color: #151515;color:white">
                <input type="tel" name="phone" placeholder="Phone Number" class="form-control" required style="background-color: #151515;color:white">
                
                <select name="session_type" required class="form-control" style="background-color: #151515;color:white">
                    <option value="personal_training">Personal Training</option>
                    <option value="group_class">Group Class</option>
                    <option value="yoga">Yoga</option>
                </select><br>
                
                <input type="date" name="appointment_date" class="form-control" required style="background-color: #151515;color:white">
                <input type="time" name="appointment_time" class="form-control" required style="background-color: #151515;color:white">

                <textarea name="remark" placeholder="Any additional remarks or preferences..." class="form-control" style="background-color: #151515;color:white; margin-top: 15px; height: 100px;"></textarea>

                <button type="submit" style="margin-top: 20px;">Book Appointment</button>
            </form>
        </div>
    </div>
</section>
@endsection
@section('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-KyZXEJH1BBt6G5D8a1g6MXvS2WgW6Dl2Zj9YzO77Jr5FvwWe9wS5kl9XqCEuLaD1" crossorigin="anonymous"></script> --}}
@endsection
