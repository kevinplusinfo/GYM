<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Gallery;  

class GalleryController extends Controller
{
    public function index(){
        $images = Gallery::all();
        return view('Customer.Gallery.Index', ['images' => $images]);
    }  
}
