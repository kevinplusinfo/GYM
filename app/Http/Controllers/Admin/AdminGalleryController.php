<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Gallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGalleryController extends Controller
{
    public function gallery()
    {
        $images = Gallery::all();
        return view('Admin.Gallery.Gallery', ['images' => $images]);
    }

    public function form()
    {
        return view('Admin.Gallery.Add');
    }

    public function uplode(Request $request, $id = null)
    {
        if ($id) {
            $Gallery = Gallery::find($id);
            if (!$Gallery) {
                return response()->json(['error' => 'Gallery item not found.'], 404);
            }
        } else {
            $Gallery = new Gallery();
        }

        $request->validate([
            'image' => $id ? 'image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($id && $Gallery->img && Storage::exists('public/' . $Gallery->img)) {
                Storage::delete('public/' . $Gallery->img);
            }

            $path = $image->store('images', 'public');
            $Gallery->img = $path;
        }

        $Gallery->alt = $request->input('alt');
        $Gallery->save();
        $message = "Blog created successfully";
        return redirect()->route('gallery.gallery')->with('success', $message);
    }

    public function update($id)
    {
        $Gallery = Gallery::find($id);
    //    dd($Gallery);
        return view('Admin.Gallery.Add', ['Gallery' => $Gallery]);
    }

    public function delete($id)
    {
        $Gallery = Gallery::find($id);

        if ($Gallery->img && Storage::exists('public/' . $Gallery->img)) {
            Storage::delete('public/' . $Gallery->img);
        }

        $Gallery->delete();
        return response()->json(['success' => 'Gallery item deleted successfully.']);
    } 
}

