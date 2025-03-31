@extends('admin.layout.main')
@section('title', 'Trainer')
@section('content-header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1>Trainer</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('trainer.index') }}">Trainer</a></li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <form method="GET" action="{{ route('trainer.index') }}">
            <div class="row">
                <div class="col-md-2">
                    <label for="name">Name</label>
                    <input type="search" name="name" id="name" class="form-control" 
                           placeholder="Search For Name" value="{{ request()->get('name') }}">
                </div>
                <div class="col-md-2">
                    <label for="action">Action</label><br>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
        <div class="float-right">
            <a href="{{ route('trainer.form') }}" class="btn btn-primary btn-sm">Add Trainer</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Experience</th>
                                <th>Expertise</th>
                                <th>Description</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trainers as $index => $trainer)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($trainer->image)
                                        <img src="{{ asset('storage/' . $trainer->image) }}" width="50" height="50" style="border-radius: 50%;">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>{{ $trainer->name }}</td>
                                <td>{{ $trainer->email }}</td>
                                <td>{{ $trainer->phone }}</td>
                                <td>{{ $trainer->experience }} Years</td>
                                <td>{{ $trainer->expertise }}</td>
                                <td>{{ $trainer->remark }}</td>
                                <td><a href="{{ route('trainer.edit', $trainer->id) }}"><i class="far fa-edit text-success"></i></a></td>
                                <td>
                                    <a href="{{ route('trainer.delete', $trainer->id) }}" onclick="return confirm('Are you sure you want to delete this trainer?')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </td>
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
     $("#precaution").val("{{@$_GET['precaution']}}");
     $(document).ready(function(){
        $(".sidebar .nav-link").removeClass('active');
        $(".team-link").addClass('active');
    });
</script>
@endsection