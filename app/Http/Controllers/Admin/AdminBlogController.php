<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Blog;
use App\Models\Admin\Tags;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AdminBlogController extends Controller
{
    public function blog()
    {
        $blog = Blog::with('tags')->get();
        return view('Admin.Blog.Blog', ['blog' => $blog]);
    }

    public function form()
    {
        return view('Admin.Blog.Add');
    }

    public function add(Request $request, $id = null)
    {
        $status = $request->has('active') ? 0 : 1;

        if ($id) {
            $blog = Blog::find($id);

            if (!$blog) {
                return redirect()->back()->with('error', 'Blog not found.');
            }

            if ($request->hasFile('img')) {
                $image = $request->file('img');

                if ($blog->img && Storage::exists('public/' . $blog->img)) {
                    Storage::delete('public/' . $blog->img);
                }

                $resizedImage = Image::make($image)->resize(800, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $imagePath = 'images/' . uniqid() . '.' . $image->getClientOriginalExtension();
                $resizedImage->save(public_path('storage/' . $imagePath));
                $blog->img = $imagePath;
            }

            $blog->title = $request->input('title');
            $blog->description = $request->input('description');
            $blog->status = $status;
            $blog->save();

            if ($request->has('tags')) {
                $tags = array_filter($request->input('tags'), function ($tag) {
                    return !is_null($tag) && trim($tag) !== '';
                });

                Tags::where('blog_id', $blog->id)->delete();

                foreach ($tags as $tagName) {
                    Tags::create([
                        'tags' => trim($tagName),
                        'blog_id' => $blog->id,
                    ]);
                }
            }

            $message = "Blog updated successfully";
        } else {
            $imagePath = null;

            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $resizedImage = Image::make($image)->resize(800, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $imagePath = 'images/' . uniqid() . '.' . $image->getClientOriginalExtension();
                $resizedImage->save(public_path('storage/' . $imagePath));
            }

            $blog = Blog::create([
                'title' => $request->input('title'),
                'img' => $imagePath,
                'description' => $request->input('description'),
                'status' => $status,
            ]);

            if ($request->has('tags')) {
                $tags = array_filter($request->input('tags'), function ($tag) {
                    return !is_null($tag) && trim($tag) !== '';
                });

                foreach ($tags as $tagName) {
                    Tags::create([
                        'tags' => trim($tagName),
                        'blog_id' => $blog->id,
                    ]);
                }
            }

            $message = "Blog created successfully";
        }

        return redirect()->route('blog.blog')->with('success', $message);
    }

    public function update($id)
    {
        $Blog = Blog::with('tags')->find($id);
        return view('Admin.Blog.Add' , ['Blog' => $Blog]);
    }

    public function delete($id)
    {
        $Blog = Blog::find($id);
        $Blog->tags()->delete();
        if ($Blog->img && Storage::exists('public/' . $Blog->img)) {
            Storage::delete('public/' . $Blog->img);
        }
        $Blog->delete();
        return redirect()->route('blog.blog')->with('alert_success', 'Blog  deleted successfully.');
    }
    
}
