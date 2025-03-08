@extends('admin.layout.main')
@section('title', 'Plans')
@section('styles')
<link href="{{ asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<style>
    .error {
        color: red;
        font-weight: normal !important;
    }
    #reportrange {
        cursor: pointer;
    }
    .daterangepicker .calendar th, .daterangepicker .calendar td {
        font-family: monospace !important;
    }
    .cursor-pointer {
        cursor: pointer;
    }

    .container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
    }

    input[type="text"],
    input[type="number"],
    input[type="email"],
    textarea,
    select {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    textarea {
        resize: vertical;
    }

    .features {
        margin-bottom: 20px;
    }

    .feature-option {
        margin-bottom: 10px;
    }

    .submit-btn {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    .submit-btn:hover {
        background-color: #0056b3;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .form-column {
        width: 48%;
        border: 2px solid #e0e0e0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 6px;
        background-color: #fafafa;
    }

    .card {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .breadcrumb {
        margin-bottom: 0;
    }
</style>
@endsection

@section('content-header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Plans</li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <form action="{{ route('plan.add') }}/{{ isset($plan) ? $plan->id : '' }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12 mt-3">
                                <div class="card-header" style="background-color: rgb(200, 200, 221)">
                                    <h3 class="card-title">Detail</h3>
                                </div>
                                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="plan_name">Plan Name:</label>
                                            <input type="text" id="plan_name" name="plan_name" class="form-control" placeholder="Enter the name of the plan" required value="{{ isset($plan) ? $plan->name : '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="plan_description">Plan Description:</label>
                                            <textarea id="plan_description" name="plan_description" class="form-control" rows="4" placeholder="Enter a brief description of the plan" required>{{ isset($plan) ? $plan->description : '' }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="plan_duration">Duration (in months):</label>
                                            <input type="number" id="plan_duration" class="form-control" name="plan_duration" min="1" required value="{{ isset($plan) ? $plan->duration : '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="plan_price">Price (₹):</label>
                                            <input type="number" id="plan_price" class="form-control" name="plan_price" step="0.01" required value="{{ isset($plan) ? $plan->price : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 mt-3">
                                <div class="card-header" style="background-color: rgb(205, 205, 219)">
                                    <h3 class="card-title">Plan Features</h3>
                                </div>
                                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                    <div class="card-body">
                                        {{--
                                        <div class="form-group">
                                            <label for="plan_features">Features</label>
                                            <select id="plan_features" name="features[]" class="form-control" multiple="multiple" required>
                                                @foreach($planfeature as $feature)
                                                    <option value="{{ $feature->id }}" 
                                                        {{ isset($plan) && in_array($feature->id, $plan->features->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                        {{ $feature->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        --}}
                                        <div class="form-group">
                                            <label for="plan_features">Features</label>
                                            <select id="plan_features" name="features[]" class="form-control" multiple="multiple" required>
                                                @foreach($feature_lists as $f)
                                                    <option value="{{ $f->id }}" @if(isset($plan) && in_array($f->id, $plan->feature()->pluck('feature_id')->toArray())) selected @endif>
                                                        {{$f->name}}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="card-header" style="background-color: rgb(203, 203, 221)">
                                    <h3 class="card-title">Payment Options</h3>
                                </div>
                                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                    <div class="card-body">
                                        <div class="form-group mb-4">
                                            <label for="payment_type" class="form-label">Payment Type:</label>
                                            <select id="payment_type" name="payment_type" class="form-select" required>
                                                <option value="one-time">One-time Payment</option>
                                                <option value="installments">Installments</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex gap-4 mt-2">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="active" id="active" {{ isset($plan) && $plan->status == 'Active' ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="active">Plan Status (Active/Inactive)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-right mb-3" style="background-color: #e0e4e6">
                        <a href="{{ route('plan.plan') }}" class="btn btn-default btn-sm">Cancel</a>&nbsp;&nbsp;
                        <button type="submit" id="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/daterange-picker/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterange-picker/js/daterangepicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $('#plan_features').select2({
            placeholder: "Select Plan Features",
            allowClear: true
        });

        $(".sidebar .nav-link").removeClass('active');
        $(".plan-link").addClass('active');
    </script>
@endsection

