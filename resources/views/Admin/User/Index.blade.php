@extends('admin.layout.main')
@section('title', 'user')
@section('content-header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1>User's</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">User</a></li>
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
        <form method="GET" action="{{ route('admin.user') }}">
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
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card mt-3">
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 1 ; ?>
                            @foreach($user as $users )
                            <tr>
                                <td>{{ $index ++ }}</td>
                                <td>
                                    @if($users->profile_image)
                                        <img src="{{ asset('storage/' . $users->profile_image) }}" width="50" height="50" style="border-radius: 50%;">
                                    @else
                                    <img src="{{ asset('storage/images/35-350426_profile-icon-png-default-profile-picture-png-transparent.png') }}" width="50" height="50" style="border-radius: 50%;">
                                    @endif
                                </td>
                                <td>{{ $users->name }}</td>
                                <td>{{ $users->email }}</td>
                                <td>{{ $users->mno }}</td>
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
        $(".user-link").addClass('active');
    });
</script>
@endsection