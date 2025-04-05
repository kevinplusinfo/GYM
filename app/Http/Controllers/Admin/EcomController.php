<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use App\Models\Admin\Flavor;
use App\Models\Admin\ProductFlavor;
use App\Models\Admin\ProductFlavorSize;
use App\Models\Customer\Product_Order;
use App\Models\Customer\ProductCart;




use Illuminate\Support\Facades\Storage;

class EcomController extends Controller
{
    public function index(){
        $products = Product::with(['images'])->get();
        return view('Admin.Ecom.product', compact('products'));
    }

    public function form($id = null){
        $product =  Product::with(['images', 'productFlavors.flavor', 'productFlavors.sizes'])->find($id);
        $flavors = Flavor::all();

        return view('Admin.Ecom.AddProduct', compact('product', 'flavors'));
    }

    public function uploadImages(Request $request)
    {
        if ($request->hasFile('images')) {
            $uploadedPaths = [];
            $isMainImage = $request->input('is_main') === 'true'; 

            foreach ($request->file('images') as $file) {
                $folder = $isMainImage ? 'products' : 'product_images'; 
                $path = $file->store($folder, 'public'); 
                $uploadedPaths[] = str_replace('public/', '', $path); 
            }

            return response()->json([
                'success' => true,
                'paths' => $uploadedPaths
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No images were uploaded'
        ], 400);
    }
 
    public function save(Request $request, $id = null)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'specification' => 'required|string',
            'mainimg' => $id ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'flavore' => 'required|array',
            'flavore.*' => 'integer|exists:flavors,id',
            'weight' => 'required|array',
            'price' => 'required|array',
            'qty' => 'required|array',
            'strike_price' => 'nullable|array'
        ]);
    
        if ($id) {
            $product = Product::findOrFail($id);
        } else {
            $product = new Product();
        }
    
        $product->title = $request->title;
        $product->description = $request->description;
        $product->specification = $request->specification;

        if ($request->has('main_image_path')) {
            $product->main_image = $request->main_image_path;
        }
        
        $product->save();
        
        if ($request->has('uploaded_images')) {
            $existingImages = ProductImage::where('product_id', $product->id)
                                          ->pluck('image')
                                          ->toArray();
        
            $newImages = $request->uploaded_images;
        
            $imagesToDelete = array_diff($existingImages, $newImages);
        
            ProductImage::where('product_id', $product->id)
                        ->whereIn('image', $imagesToDelete)
                        ->delete();
        
            foreach ($newImages as $imagePath) {
                if (!in_array($imagePath, $existingImages)) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imagePath
                    ]);
                }
            }
        }
    
        $existingFlavors = $product->flavors()->pluck('flavor_id')->toArray();
    
        foreach ($request->flavore as $flavorIndex => $flavor_id) {
            if (in_array($flavor_id, $existingFlavors)) {
                $productFlavor = $product->flavors()->where('flavor_id', $flavor_id)->first();
            } else {
                $productFlavor = ProductFlavor::create([
                    'product_id' => $product->id,
                    'flavor_id' => $flavor_id
                ]);
            }
    
            $existingSizes = $productFlavor->sizes()->pluck('id')->toArray();
            $requestSizes = array_keys($request->weight[$flavorIndex]);
    
            foreach ($request->weight[$flavorIndex] as $key => $weight) {
                if (in_array($key, $existingSizes)) {
                    $size = $productFlavor->sizes()->find($key);
                    $size->update([
                        'weight' => $weight,
                        'price' => $request->price[$flavorIndex][$key],
                        'qty' => $request->qty[$flavorIndex][$key],
                        'strike_price' => $request->strike_price[$flavorIndex][$key] ?? null
                    ]);
                } else {
                    ProductFlavorSize::create([
                        'product_flavor_id' => $productFlavor->id,
                        'weight' => $weight,
                        'price' => $request->price[$flavorIndex][$key],
                        'qty' => $request->qty[$flavorIndex][$key],
                        'strike_price' => $request->strike_price[$flavorIndex][$key] ?? null
                    ]);
                }
            }
    
            $sizesToDelete = array_diff($existingSizes, $requestSizes);
            if (!empty($sizesToDelete)) {
                $productFlavor->sizes()->whereIn('id', $sizesToDelete)->delete();
            }
        }
    
        $flavorsToDelete = array_diff($existingFlavors, $request->flavore);
        if (!empty($flavorsToDelete)) {
            $product->flavors()->whereIn('flavor_id', $flavorsToDelete)->each(function ($flavor) {
                $flavor->sizes()->delete();
            });

            $product->flavors()->whereIn('flavor_id', $flavorsToDelete)->delete();
        }
    
        return redirect()->route('product.index')->with('success', 'Product saved successfully.');
    }

    public function delete($id)
    {
        $product = Product::with('images', 'flavors.sizes')->find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        if ($product->main_image && Storage::exists('public/' . $product->main_image)) {
            Storage::delete('public/' . $product->main_image);
        }

        foreach ($product->images as $image) {
            if ($image->image && Storage::exists('public/' . $image->image)) {
                Storage::delete('public/' . $image->image);
            }
            $image->delete();
        }

        foreach ($product->flavors as $flavor) {
            ProductFlavorSize::where('product_flavor_id', $flavor->id)->delete();
        }

        ProductFlavor::where('product_id', $product->id)->delete();

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product and all associated data deleted successfully.');
    }

    public function deleteImage(Request $request)
    {
        $imageId = $request->input('image_id');
        $imageType = $request->input('image_type');
        $imagePath = $request->input('image_path');

        if ($imageType === 'main') {
            $product = Product::find($imageId);
            if ($product && $product->main_image === $imagePath) {
                Storage::delete('public/' . $imagePath);

                $product->main_image = null;
                $product->save();
                return response()->json(['success' => true]);
            }
        } elseif ($imageType == 'additional') {
            $image = ProductImage::find($imageId);
            if ($image && $image->image == $imagePath) {
                Storage::delete('public/' . $imagePath);
                $image->delete();
                return response()->json(['success' => true]);
            }
        }
        
        return response()->json(['success' => false, 'message' => 'Image not found'], 404);
    }

    public function orders(Request $request)
    {
        $orders = Product_Order::with([
            'orderItems', 
            'orderItems.product', 
            'orderItems.productFlavor.flavor',
            'orderItems.productFlavorSize'
        ])->whereHas('orderItems', function ($query) use ($request) {
    
            if ($request->filled('name')) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->name . '%');
                });
            }
    
            if ($request->filled('min_price')) {
                $query->whereHas('productFlavorSize', function ($q) use ($request) {
                    $q->where('price', '>=', $request->min_price);
                });
            }
    
            if ($request->filled('max_price')) {
                $query->whereHas('productFlavorSize', function ($q) use ($request) {
                    $q->where('price', '<=', $request->max_price);
                });
            }
    
        });
    
        if ($request->filled('created_at')) {
            $orders->whereDate('created_at', $request->created_at);
        }
    
        $orders = $orders->get();
    
        return view('Admin.Ecom.orders', compact('orders'));
    }
    public function getOrderDetails(Request $request)
    {
       
        $order = Product_Order::where('id', $request->id)
        ->with([
            'orderItems' => function ($query) {
                $query->select('id', 'order_id', 'product_id', 'product_flavor_id', 'product_flavor_size_id', 'qty', 'total_price');
            },
            'orderItems.product:id,main_image,title',
            'orderItems.productFlavor.flavor:id,name',
            'orderItems.productFlavorSize:id,weight,price'
        ])
        ->first();
            // dd($order);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
    
        $html = "<p><b> No:</b> {$order->order_no}</p>
                 <p><b>Customer:</b> {$order->name}</p>
                 <p><b>Email:</b> {$order->email}</p>
                 <p><b>Phone:</b> {$order->phone}</p>
                 <p><b>Address:</b> {$order->address}, {$order->city}, {$order->state} - {$order->zipcode}</p>
                 <p><b>Payment Status:</b> {$order->payment_status}</p>
                 <p><b>Order Date:</b> {$order->created_at}</p>";
    
        if ($order->orderItems->isEmpty()) {
            return response()->json(['error' => 'No items found for this order'], 404);
        }
        $html .= "<h5>Order Items:</h5>
                  <table class='table table-striped'>
                          <tr>
                              <th>Image</th>
                              <th>Product</th>
                              <th>Flavor</th>
                              <th>Size</th>
                              <th>Price</th>
                              <th>Qty</th>
                              <th>Total</th>
                          </tr>
                    ";
    
                      foreach ($order->orderItems as $item) {
                        $imagePath = $item->product->main_image ?? 'default.jpg'; 
                        $imageUrl = Storage::url($imagePath); 
                    
                        $html .= "<tr>
                                      <td><img src='{$imageUrl}' width='50' height='50' alt='Product Image'></td>
                                      <td>" . ($item->product->title ?? 'N/A') . "</td>
                                      <td>" . ($item->productFlavor->flavor->name ?? 'N/A') . "</td>
                                      <td>" . ($item->productFlavorSize->weight ?? 'N/A') . "g</td>
                                      <td>₹" . number_format($item->total_price / max($item->qty, 1)) . "</td>
                                      <td>{$item->qty}</td>
                                      <td>₹" . number_format($item->total_price) . "</td>
                                  </tr>";
                    }
                    $totalPrice = $order->orderItems->sum('total_price');
                    $html .= "</table><div style='text-align: right; font-weight: bold; margin-top: 10px;'>
                                <strong>Total Amount:</strong> ₹" . number_format($totalPrice) . "
                            </div>";
    
        return response()->json(['html' => $html]); 
    }

    public function cartdetail()
    {
        $cartItems = ProductCart::with([
            'customer:id,name,email,mno', 
            'product:id,main_image,title', 
            'productFlavor.flavor:id,name', 
            'productFlavorSize:id,weight,price'
        ])->get();

        return view('Admin.Ecom.cartdetail', compact('cartItems'));
    }

    public function getCartDetails(Request $request)
    {
        $cartItems = ProductCart::with([
            'customer:id,name,email,mno',
            'product:id,main_image,title',
            'productFlavor.flavor:id,name',
            'productFlavorSize:id,weight,price'
        ])->where('customer_id', $request->customer_id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'No items found in the cart'], 404);
        }

        $customer = $cartItems->first()->customer;
        $totalQty = 0;
        $grandTotal = 0;

        $html = "<p><b>Customer:</b> {$customer->name}</p>
                <p><b>Email:</b> {$customer->email}</p>
                <p><b>Phone:</b> {$customer->mno}</p>";

        $html .= "<h5>Cart Summary:</h5>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Flavor</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($cartItems as $cartItem) {
            $imagePath = $cartItem->product->main_image ?? 'default.jpg';
            $imageUrl = Storage::url($imagePath);

            $itemTotal = $cartItem->productFlavorSize->price * $cartItem->qty;
            $grandTotal += $itemTotal;
            $totalQty += $cartItem->qty;

            $html .= "<tr>
                        <td><img src='{$imageUrl}' width='50' height='50' alt='Product Image'></td>
                        <td>{$cartItem->product->title}</td>
                        <td>{$cartItem->productFlavor->flavor->name}</td>
                        <td>{$cartItem->productFlavorSize->weight}g</td>
                        <td>{$cartItem->qty}</td>
                        <td>{$cartItem->productFlavorSize->price}</td>
                        <td>₹" . number_format($itemTotal, 2) . "</td>
                    </tr>";
        }

        $html .= "<tr>
                    <td colspan='4' style='text-align:right; font-weight:bold;'>Total Quantity:</td>
                    <td style='font-weight:bold;'>{$totalQty}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                <td></td>
                    <td colspan='5' style='text-align:right; font-weight:bold;'>Grand Total:</td>
                    <td style='font-weight:bold;'>₹" . number_format($grandTotal, 2) . "</td>
                
                </tr>";

        $html .= "</tbody></table>";

        return response()->json(['html' => $html]);
    }
    
}    


