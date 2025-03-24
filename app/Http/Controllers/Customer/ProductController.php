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
use App\Models\Customer\Product_order;
use App\Models\Customer\Product_order_Item;

use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;


class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('Customer.Ecommerce.index', compact('products'));
    }

    public function detail($id)
    {
        // $product =  Product::with(['images', 'productFlavors.flavor', 'productFlavors.sizes'])->find($id);
        $product = Product::with([
            'images',
            'productFlavors.flavor',
            'productFlavors.sizes' => function ($query) {
                $query->where('qty', '>', 0);
            }
        ])->find($id);

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
            $cartItem->qty = $request->qty; 
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
        ->with([
            'product:id,main_image',
            'productFlavor.flavor:id,name',
            'productFlavorSize:id,weight,price'
        ])
        ->get();

        // return response()->json($cartItems);

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

    public function checkout(){
        $customer_id = auth()->id();

        if (!$customer_id) {
            return redirect()->route('clogin')->with('error', 'Please login to view your cart.');
        }

        $cartItems = ProductCart::where('customer_id', $customer_id)
        ->with([
            'product:id,main_image',
            'productFlavor.flavor:id,name',
            'productFlavorSize:id,weight,price'
        ])
        ->get();
        return view('Customer.Ecommerce.checkout',compact('cartItems'));
    }

    public function placeOrder(Request $request)
    {
        // dd(123);
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'zipcode' => 'required',
            'city' => 'required',
            'state' => 'required',
        ]);

        $customer = Auth::user();
        $cartItems = ProductCart::where('customer_id', $customer->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item->productFlavorSize->price  * $item->qty;
        }
        // dd($totalAmount);
        $api = new Api("rzp_test_V8dTVLLCGqG1nv", "OxMzmumc2RBEwMkPqnU32I7m");
        $order = $api->order->create([
            'receipt' => 'ORDER_' . uniqid(),
            'amount' => $totalAmount * 100, 
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        $newOrder = new Product_order();
        $newOrder->customer_id = $customer->id;
        $newOrder->order_no = 'ORD-' . strtoupper(uniqid());
        $newOrder->razorpay_order_id = $order['id'];
        $newOrder->payment_status = 'Pending';
        $newOrder->name = $request->name;
        $newOrder->email = $request->email;
        $newOrder->phone = $request->phone;
        $newOrder->address = $request->address;
        $newOrder->zipcode = $request->zipcode;
        $newOrder->city = $request->city;
        $newOrder->state = $request->state;
        $newOrder->save();

        foreach ($cartItems as $item) {
            $orderItem = new Product_order_Item();
            $orderItem->order_id = $newOrder->id;
            $orderItem->product_id = $item->product_id;
            $orderItem->product_flavor_id = $item->productflavor_id;
            $orderItem->product_flavor_size_id = $item->productflavorsize_id;
            $orderItem->qty = $item->qty;
            $orderItem->total_price = $item->qty * $item->product->price;
            $orderItem->save();

            $productFlavorSize = ProductFlavorSize::find($item->productflavorsize_id);
            if ($productFlavorSize) {
                $productFlavorSize->qty -= $item->qty;
                $productFlavorSize->save();
            }
        }

        ProductCart::where('customer_id', $customer->id)->delete();

        return view('Customer.Ecommerce.payment', [
            'order_id' => $order['id'],
            'amount' => $totalAmount * 100, 
            'key' => env('RAZORPAY_KEY'),
            'order' => $newOrder
        ]);
    }
    public function paymentverify(Request $request){
        $api = new Api("rzp_test_V8dTVLLCGqG1nv", "OxMzmumc2RBEwMkPqnU32I7m");

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];
            $api->utility->verifyPaymentSignature($attributes);

            $order = Product_Order::where('razorpay_order_id', $request->razorpay_order_id)->first();

            if (!$order) {
                return redirect()->route('product')->with('error', 'Order not found.');
            }

            $order->razorpay_payment_id = $request->razorpay_payment_id;
            $order->razorpay_signature = $request->razorpay_signature;
            $order->payment_status = 'Paid';
            $order->save();

            return redirect()->route('purchase.product', ['order_id' => $order->id])
                ->with('success', 'Payment successful!');

        } catch (\Exception $e) {
            return redirect()->route('product')->with('error', 'Payment failed! ' . $e->getMessage());
        }
    }

    public function purchaseproduct($order_id)
    {
        dd(123);
        $orders = Product_Order::where('id', $order_id)
            ->with([
                'orderItems' => function ($query) {
                    $query->select('id', 'product_order_id', 'product_id', 'product_flavor_id', 'product_flavor_size_id', 'quantity', 'price');
                },
                'orderItems.product:id,main_image,name',
                'orderItems.productFlavor.flavor:id,name',
                'orderItems.productFlavorSize:id,weight,price'
            ])
            ->get();
            return view('Customer.Ecommerce.orderditem',compact('orders'));
    
    }
} 
