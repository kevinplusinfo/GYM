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

        $product = $id ? Product::find($id) : new Product();

        if ($id && !$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $product->title = $request->title;
        $product->description = $request->description;
        $product->specification = $request->specification;

        $product->main_image = $request->file('mainimg')->store('products', 'public');

        $product->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image = $file->store('product_images', 'public');
                $productImage->save();
            }
        }

        if ($request->filled('flavore')) {
            foreach ($request->input('flavore') as $index => $flavor_id) {
                if (!empty($flavor_id) && is_numeric($flavor_id)) {
                    $productFlavor = ProductFlavor::updateOrCreate(
                        ['product_id' => $product->id, 'flavor_id' => $flavor_id]
                    );

                    if (!empty($request->weight[$index])) {
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
        $product->delete();
    
        return redirect()->route('product.index')->with('success', 'Product and all associated data deleted successfully.');
    }
}    
