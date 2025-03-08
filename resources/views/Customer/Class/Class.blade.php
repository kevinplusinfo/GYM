@extends('Customer.layout.main')
@section('title')Class @endsection
@section('styles')
<link href="{{asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
<style>
    .error{color: red;font-weight: normal!important;}
    #reportrange{cursor: pointer;}
    .daterangepicker .calendar th, .daterangepicker .calendar td{font-family: monospace!important;}
    /*#add_medicine{margin-left: 920px;}*/
    .badge{font-size: 15px;cursor: pointer}
    th,td{text-align: center;}
        * {
  box-sizing: border-box;
}
body {
  margin: 0;
  font-family: Arial;
}
.header {
  text-align: center;
  padding: 32px;
}
.row {
  display: flex;
  flex-wrap: wrap;
  padding: 0 4px;
}
.column {
  flex: 25%;
  max-width: 25%;
  padding: 0 4px;
}
.column img {
  margin-top: 8px;
  vertical-align: middle;
}
@media (max-width: 800px) {
  .column {
    flex: 50%;
    max-width: 50%;
  }
}
@media (max-width: 600px) {
  .column {
    flex: 100%;
    max-width: 100%;
  }
  
}
.ci-pic {
        width: 100%;
        height: 250px; 
        overflow: hidden;
    }

    .ci-pic .class-img {
        width: 100%;
        height: 100%;
        object-fit: cover; 
        display: block;
    }
    
</style>
@endsection
@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="{{asset('assets/img/breadcrumb-bg.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Class</h2>
                        <div class="bt-option">
                            <a href="{{route('index.gallery')}}">Home</a>
                            <span>Class</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="classes-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Our Classes</span>
                        <h2>WHAT WE CAN OFFER</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($class as $class)
                    <div class="col-lg-4 col-md-6">
                        <div class="class-item">
                            <div class="ci-pic">
                                <div class="gs-item grid-wide set-bg">
                                    <img src="{{ Storage::url($class->img) }}" class="">
                                    <i class="fa fa-picture-o"></i>
                                </div>
                            </div>
                            <div class="ci-text">
                                <span>STRENGTH</span>
                                <h5>{{$class->title}}</h5>
                                <a href="{{ route('class.detail', $class->id) }}">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection