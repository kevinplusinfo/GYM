<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use App\Models\Admin\Flavor;
use App\Models\Admin\ProductFlavor;
use App\Models\Admin\ProductFlavorSize;
use App\Models\Customer\ProductCart;


class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('Customer.Ecommerce.index', compact('products'));
    }

    public function detail($id)
    {
        $product =  Product::with(['images', 'productFlavors.flavor', 'productFlavors.sizes'])->find($id);

        return view('Customer.Ecommerce.productdetail', compact('product'));
    }

    public function store(Request $request, $id = null)
    {
        
        $cartItem = ProductCart::where('customer_id', $request->customer_id)
        ->where('product_id', $request->product_id)
        ->where('productflavor_id', $request->productflavor_id)
        ->where('productflavorsize_id', $request->productflavorsize_id)
        ->first();

    if ($cartItem) {
        $cartItem->qty = $request->qty; // Update quantity
        $cartItem->save();
    } else {
        $cartItem = ProductCart::create([
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id,
            'productflavor_id' => $request->productflavor_id,
            'productflavorsize_id' => $request->productflavorsize_id,
            'qty' => $request->qty
        ]);
    }

    return response()->json([
        'message' => 'Cart updated successfully!',
        'qty' => $cartItem->qty
    ]);
}
    

    public function cartdetail()
    {
        $customer_id = auth()->id();
    
        if (!$customer_id) {
            return redirect()->route('clogin')->with('error', 'Please login to view your cart.');
        }
    
        $cartItems = ProductCart::where('customer_id', $customer_id)
            ->with(['product', 'productFlavor', 'productFlavorSize'])
            ->get();
        dd($cartItems);
        return view('Customer.Ecommerce.cartdetail', compact('cartItems'));
    }

    public function clearCart(Request $request )
    {

            $deleted = ProductCart::where('customer_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->where('productflavor_id', $request->productflavor_id)
            ->where('productflavorsize_id', $request->productflavorsize_id)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Item removed from cart!']);
        }
    
        return response()->json(['error' => true, 'message' => 'Item not found in cart!'], 404);
    }
}
