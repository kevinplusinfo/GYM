@extends('admin.layout.main')

@section('title', 'Appointments')

@section('content-header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1>Appointments</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('appointment.index') }}">Appointments</a></li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="float-right">
        </div><br>
        <div class="card mt-3">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Client Name</th>
                                <th>Email</th>
                                <th>Class</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $index => $appointment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $appointment->name }}</td>
                                <td>{{ $appointment->email }}</td>
                                <td>{{ $appointment->phone }}</td>
                                <td>{{ $appointment->class }}</td>
                                <td>{{ $appointment->appointment_date }}</td>
                                <td>{{ $appointment->appointment_time }}</td>
                                <td>{{ $appointment->remark }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $(".sidebar .nav-link").removeClass('active');
        $(".appointment-link").addClass('active');
    });
</script>
@endsection
