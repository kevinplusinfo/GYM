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
        // dd($request->all());
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
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image = $file->store('product_images', 'public');
                $productImage->save();
            }
        }
    
        $newFlavors = $request->input('flavore', []);
    
        ProductFlavor::where('product_id', $product->id)
            ->whereNotIn('flavor_id', $newFlavors)
            ->delete();
    
        foreach ($newFlavors as $flavorIndex => $flavor_id) {
            $productFlavor = ProductFlavor::firstOrCreate([
                'product_id' => $product->id,
                'flavor_id' => $flavor_id
            ]);
    
            $newWeights = $request->weight[$flavorIndex] ?? [];
    
            ProductFlavorSize::where('product_flavor_id', $productFlavor->id)
                ->whereNotIn('weight', $newWeights)
                ->delete();
    
            foreach ($newWeights as $key => $weight) {
                ProductFlavorSize::updateOrCreate(
                    [
                        'product_flavor_id' => $productFlavor->id,
                        'weight' => $weight
                    ],
                    [
                        'price' => $request->price[$flavorIndex][$key],
                        'qty' => $request->qty[$flavorIndex][$key],
                        'strike_price' => $request->strike_price[$flavorIndex][$key] ?? null
                    ]
                );
            }
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


