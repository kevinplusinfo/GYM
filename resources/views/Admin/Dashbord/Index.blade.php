@extends('admin.layout.main')
@section('title')Dashbord @endsection
@section('styles')
<link href="{{asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
<style>
    .error{color: red;font-weight: normal!important;}
    #reportrange{cursor: pointer;}
    .daterangepicker .calendar th, .daterangepicker .calendar td{font-family: monospace!important;}
    #add_medicine{margin-left: 950px;}
    .cursor-pointer{cursor: pointer;}
</style>
@endsection
@section('content-header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashbord</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active"><a href="#">Dashbord</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection
@section('content')

<div class="wrapper">
    {{-- <div class="content-wrapper" > --}}
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner" >
                            <h3 >{{$user}}</h3>
                            <p>Total User</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('admin.user')}}" class="small-box-footer">More info 
                            <i  class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 ><sup style="font-size: 20px"></sup></h3>
                            <p>This Month</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#"  class=" small-box-footer">More info 
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3  class="month"> </h3>
                            <p>This Week</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#"  class="small-box-footer">More info 
                            <i name="Week" class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3> </h3>
                            <p>Today</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info
                            <i name="Today" class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>  	
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$trainer}}</h3>
                            <p>Total Trainer</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-cart-shopping "></i>
                        </div>
                        <a href="{{route('trainer.index')}}" class="small-box-footer">More info
                            <i name="Today" class="fa-solid fa-arrow-circle-down"></i>
                         </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3></h3>
                            <p> Cart Qty</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-cart-arrow-down"></i>
                        </div>
                        <a href="cart.php" class="small-box-footer">More info
                            <i name="Today" class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}
</div>            
@endsection
@section('scripts')
<script src="{{asset('assets/plugins/daterange-picker/js/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/daterange-picker/js/daterangepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
     $(document).ready(function(){
        $(".sidebar .nav-link").removeClass('active');
        $(".dashbord-link").addClass('active');
    });
</script>
@endsection