@extends('admin.layout.main')
@section('title', 'Add Trainer')

@section('content-header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1>{{ isset($trainer) ? 'Edit' : 'Add' }} Trainer</h1></div>
        </div>
    </div>
</section>
@endsection

@section('content')
{{-- <div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('trainer.store', isset($trainer) ? $trainer->id : '') }}" method="post" enctype="multipart/form-data" id="form">
                    @csrf
                    <div class="mb-3">
                        <label>Image</label>   <span style="color: red;" >*</span>
                        <input type="file" name="image" class="form-control">
                        @if(isset($trainer) && $trainer->image)
                            <img src="{{ asset('storage/' . $trainer->image) }}" width="100">
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $trainer->name ?? '' }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $trainer->email ?? '' }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ $trainer->phone ?? '' }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Experience (Years)</label>
                        <input type="number" name="experience" value="{{ $trainer->experience ?? '' }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Expertise</label>
                        <textarea name="expertise" class="form-control">{{ $trainer->expertise ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Remark</label>
                        <textarea name="remark" class="form-control">{{ $trainer->remark ?? '' }}</textarea>
                    </div>

                    <div class="float-right mt-4">
                        <a href="{{ route('trainer.index') }}" class="btn btn-default btn-sm">Cancel</a>&nbsp;&nbsp;
                        <button type="submit" id="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div> --}}

<div class="row">
    <div class="col-md-12">
        {{-- <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
            <div class="card-body"> --}}
                <form action="{{ route('trainer.store', isset($trainer) ? $trainer->id : '') }}" method="post" enctype="multipart/form-data" id="form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12 mt-3">
                                <div class="card-header" style="background-color: rgb(200, 200, 221)">
                                    <h3 class="card-title">Image</h3>
                                </div>
                                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Image</label>   <span style="color: red;" >*</span>
                                            <input type="file" name="image" class="form-control">
                                            @if(isset($trainer) && $trainer->image)
                                                <img src="{{ asset('storage/' . $trainer->image) }}" width="100">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12 mt-3">
                                <div class="card-header" style="background-color: rgb(200, 200, 221)">
                                    <h3 class="card-title">Personal Detail</h3>
                                </div>
                                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Name</label>
                                            <input type="text" name="name" value="{{ $trainer->name ?? '' }}" class="form-control" required>
                                        </div>
                    
                                        <div class="mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" value="{{ $trainer->email ?? '' }}" class="form-control" required>
                                        </div>
                    
                                        <div class="mb-3">
                                            <label>Phone</label>
                                            <input type="text" name="phone" value="{{ $trainer->phone ?? '' }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 mt-3">
                                <div class="card-header" style="background-color: rgb(205, 205, 219)">
                                    <h3 class="card-title">Genral </h3>
                                </div>
                                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Experience (Years)</label>
                                            <input type="number" name="experience" value="{{ $trainer->experience ?? '' }}" class="form-control">
                                        </div>
                    
                                        <div class="mb-3">
                                            <label>Expertise</label>
                                            <textarea name="expertise" class="form-control">{{ $trainer->expertise ?? '' }}</textarea>
                                        </div>
                    
                                        <div class="mb-3">
                                            <label>Remark</label>
                                            <textarea name="remark" class="form-control">{{ $trainer->remark ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-right mb-3" style="background-color: #e0e4e6">
                        <a href="{{ route('trainer.index') }}" class="btn btn-default btn-sm">Cancel</a>&nbsp;&nbsp;
                        <button type="submit" id="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </form>
            {{-- </div>
        </div> --}}
    </div>
</div>

@endsection

@section('scripts')
<script>
     $(document).ready(function(){
        $(".sidebar .nav-link").removeClass('active');
        $(".team-link").addClass('active');
    });
</script>
@endsection