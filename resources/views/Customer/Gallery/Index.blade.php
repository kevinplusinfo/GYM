@extends('Customer.layout.main')
@section('title')Gallery @endsection
@section('styles')
<link href="{{asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
<style>
    .error{color: red;font-weight: normal!important;}
    #reportrange{cursor: pointer;}
    .daterangepicker .calendar th, .daterangepicker .calendar td{font-family: monospace!important;}
    /*#add_medicine{margin-left: 920px;}*/
    .badge{font-size: 15px;cursor: pointer}
    th,td{text-align: center;}
    <style>
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

/* Create four equal columns that sits next to each other */
.column {
  flex: 25%;
  max-width: 25%;
  padding: 0 4px;
}

.column img {
  margin-top: 8px;
  vertical-align: middle;
}

/* Responsive layout - makes a two column-layout instead of four columns */
@media (max-width: 800px) {
  .column {
    flex: 50%;
    max-width: 50%;
  }
}

/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media (max-width: 600px) {
  .column {
    flex: 100%;
    max-width: 100%;
  }
}
    
</style>
@endsection
@section('content')
<div class="gallery-section gallery-page">
    <section class="breadcrumb-section set-bg" data-setbg="{{asset('assets/img/breadcrumb-bg.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Gallery</h2>
                        {{-- <div class="bt-option">
                            <a href="./index.html">Home</a>
                            <a href="#">Pages</a>
                            <span>Gallery</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="gallery">
        <div class="grid-sizer">
            @foreach($images as $image)
            <div class="row"> 
                <div class="column">
                    <div class="gs-item grid-wide   set-bg" data-setbg="{{ Storage::url($image->img) }}">
                        <a href="{{ Storage::url($image->img) }}" width="100%" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>        
    </div>
</div>
@endsection