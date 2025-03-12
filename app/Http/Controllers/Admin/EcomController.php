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
    
        if ($request->hasFile('mainimg')) {
            $product->main_image = $request->file('mainimg')->store('products', 'public');
        }
    
        $product->save();
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $file->store('product_images', 'public')
                ]);
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

        if ($imageType === 'main') {
            $product = Product::find($imageId);
            if ($product && $product->main_image) {
                Storage::delete('public/' . $product->main_image);
                $product->main_image = null;
                $product->save();
                return response()->json(['success' => true]);
            }
        } elseif ($imageType === 'additional') {
            $image = ProductImage::find($imageId);
            if ($image && $image->image) {
                Storage::delete('public/' . $image->image);
                $image->delete();
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false]);
    }

}    


