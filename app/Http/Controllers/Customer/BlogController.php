<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Blog;  

class BlogController extends Controller
{
    public function index() {
        $Blog = Blog::where('status', '1')->paginate(5);
        return view('Customer.Blog.Index', ['Blog' => $Blog]);
    }
}
