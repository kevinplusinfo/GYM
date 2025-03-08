<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use App\Models\Admin\Flavor;
use App\Models\Admin\ProductFlavor;
use App\Models\Admin\ProductFlavorSize;


use Illuminate\Support\Facades\Storage;

class EcomController extends Controller
{
    public function index()
    {
        $products = Product::with(['images'])->get();
        return view('Admin.Ecom.product', compact('products'));
    }

    public function form($id = null)
{
    $product =  Product::with(['images', 'productFlavors.flavor', 'productFlavors.sizes'])->find($id);
    $flavors = Flavor::all();

    return view('Admin.Ecom.AddProduct', compact('product', 'flavors'));
}

    public function uploadImages(Request $request)
    {
    if ($request->hasFile('images')) {
        $uploadedPaths = [];
        $isMainImage = $request->input('is_main') === 'true'; // Check if it's a main image

        foreach ($request->file('images') as $file) {
            $folder = $isMainImage ? 'products' : 'product_images'; // Store in different folders
            $path = $file->store($folder, 'public'); // Save file in storage

            $uploadedPaths[] = Storage::url($path); // Get public URL
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
            'mainimg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'flavore' => 'required|array',
            'flavore.*' => 'integer|exists:flavors,id',
            'weight' => 'required|array',
            'weight.*' => 'required|array',
            'price' => 'required|array',
            'price.*' => 'required|array',
            'qty' => 'required|array',
            'qty.*' => 'required|array',
            'strike_price' => 'nullable|array',
            'strike_price.*' => 'nullable|array'
        ]);
    
        $product = $id ? Product::find($id) : new Product();
    
        if ($id && !$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
    
        $product->title = $request->title;
        $product->description = $request->description;
        $product->specification = $request->specification;
    
        if ($request->hasFile('mainimg')) {
            if ($product->main_image && Storage::exists('public/' . $product->main_image)) {
                Storage::delete('public/' . $product->main_image);
            }
            $product->main_image = $request->file('mainimg')->store('products', 'public');
        }
    
        $product->save();
    
        if ($request->hasFile('images')) {
            if ($id) {
                ProductImage::where('product_id', $id)->delete();
            }
            foreach ($request->file('images') as $file) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $file->store('product_images', 'public')
                ]);
            }
        }
    
        $newFlavors = $request->input('flavore', []);
    
        ProductFlavor::where('product_id', $product->id)
            ->whereNotIn('flavor_id', $newFlavors)
            ->delete();
    
        foreach ($request->flavore as $index => $flavor_id) {
            if (!empty($flavor_id) && is_numeric($flavor_id)) {
                $productFlavor = ProductFlavor::updateOrCreate(
                    ['product_id' => $product->id, 'flavor_id' => $flavor_id],
                    ['product_id' => $product->id, 'flavor_id' => $flavor_id]
                );
    
                if (
                    isset($request->weight[$index]) && is_array($request->weight[$index]) &&
                    isset($request->price[$index]) && is_array($request->price[$index]) &&
                    isset($request->qty[$index]) && is_array($request->qty[$index])
                ) {
                    ProductFlavorSize::where('product_flavor_id', $productFlavor->id)->delete();
    
                    foreach ($request->weight[$index] as $subIndex => $weight) {
                        $flavorSize = new ProductFlavorSize();
                        $flavorSize->product_flavor_id = $productFlavor->id;
                        $flavorSize->weight = $weight;
                        $flavorSize->price = $request->price[$index][$subIndex] ?? 0;
                        $flavorSize->qty = $request->qty[$index][$subIndex] ?? 0;
                        $flavorSize->strike_price = $request->strike_price[$index][$subIndex] ?? null;
                        $flavorSize->save();
                    }
                }
            }
        }
    
        return redirect()->route('product.index')->with('success', 'Product saved successfully.');
    }
    

    
    public function delete($id)
    {
        $product = Product::with('images')->find($id);
    
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
        ProductFlavorSize::where('product_id', $id)->delete();
        ProductFlavorSize::where('product_flavor_id', $id)->delete();
        $product->delete();
    
        return redirect()->route('product.index')->with('success', 'Product and all associated data deleted successfully.');
    }
}    


// public function delete($id)
// {
//     $product = Product::with('images', 'flavors.sizes')->find($id);

//     if (!$product) {
//         return redirect()->back()->with('error', 'Product not found.');
//     }

//     // Delete Main Image
//     if ($product->main_image && Storage::exists('public/' . $product->main_image)) {
//         Storage::delete('public/' . $product->main_image);
//     }

//     // Delete Product Images
//     foreach ($product->images as $image) {
//         if ($image->image && Storage::exists('public/' . $image->image)) {
//             Storage::delete('public/' . $image->image);
//         }
//         $image->delete();
//     }

//     // Delete Product Flavors and Their Sizes
//     foreach ($product->flavors as $flavor) {
//         ProductFlavorSize::where('product_flavor_id', $flavor->id)->delete();
//     }

//     // Delete Product Flavors after their sizes are deleted
//     ProductFlavor::where('product_id', $product->id)->delete();

//     // Delete Product
//     $product->delete();

//     return redirect()->route('product.index')->with('success', 'Product and all associated data deleted successfully.');
// }