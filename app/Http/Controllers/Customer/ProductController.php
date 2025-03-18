<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use App\Models\Admin\Flavor;
use App\Models\Admin\ProductFlavor;
use App\Models\Admin\ProductFlavorSize;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('Customer.Ecommerce.index', compact('products'));
    }
    public function detail($id){
        $product =  Product::with(['images', 'productFlavors.flavor', 'productFlavors.sizes'])->find($id);

        return view('Customer.Ecommerce.productdetail', compact('product'));
    }
    
}
