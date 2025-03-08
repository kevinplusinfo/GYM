<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Classes;  
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class AdminClassController extends Controller
{
   public function index(){
    $class = Classes::all();
        return view('Admin.Class.Class', ['class' => $class]);
   }
   public function form($id = null){
    if ($id) {
        $class = Classes::find($id);

        if (!$class) {
            return redirect()->route('Admin.Class.index')->with('error', 'Plan not found');
        }

        return view('Admin.Class.Add', ['class' => $class]);
    }
    return view('Admin.Class.Add');
   
   }
   public function add(Request $request, $id = null)
   {   
       if ($id) {
           $class = Classes::find($id);
   
           if (!$class) {
               return redirect()->back()->with('error', 'Class not found.');
           }
   
           if ($request->hasFile('img')) {
               $image = $request->file('img');
   
               if ($class->img && Storage::exists('public/' . $class->img)) {
                   Storage::delete('public/' . $class->img);
               }
               $imagePath = 'images/' . uniqid() . '.' . $image->getClientOriginalExtension();

               $imagePath = $image->store('images', 'public');
               $class->img = $imagePath;
           }
   
           $class->title = $request->input('title');
           $class->description = $request->input('description');
           $class->status = $request->has('active') ? 'Active' : 'Inactive';

           $class->save();
   
           $message = "Class updated successfully";
       }
        else {
           $imagePath = null;
           if ($request->hasFile('img')) {
               $image = $request->file('img');
               $imagePath = $image->store('images', 'public');
           }
           $class = Classes::create([
               'title' => $request->input('title'),
               'img' => $imagePath,
               'description' => $request->input('description'),
           ]);
           $message = "Class Created Successfully";
       }
       return redirect()->route('class.class')->with('success', $message);
    }

    public function delete($id){
        $class = Classes::find($id);
        if ($class->img && Storage::exists('public/' . $class->img)) {
            Storage::delete('public/' . $class->img);
        }
        $class->delete();
        return redirect()->route('class.class')->with('alert_success', 'Class  deleted successfully.');

    }
}
