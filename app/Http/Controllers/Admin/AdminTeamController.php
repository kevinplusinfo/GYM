<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Trainer;
use Illuminate\Support\Facades\Storage;

class AdminTeamController extends Controller
{
    public function index(){
        $trainers = Trainer::all();
        return view('Admin.Trainer.Index', compact('trainers'));
    }

    public function form($id = null)
    {
        $trainer = $id ? Trainer::find($id) : null;
        if ($id && !$trainer) {
            return redirect()->route('trainer.index')->with('error', 'Trainer not found');
        }
        return view('Admin.Trainer.Add', compact('trainer'));
    }

    public function store(Request $request, $id = null)
    {
        // Find Trainer if $id exists (Edit Mode), otherwise create a new one
        $trainer = $id ? Trainer::find($id) : new Trainer;

        if ($id && !$trainer) {
            return redirect()->route('trainer.trainer')->with('error', 'Trainer not found');
        }

        // Validation Rules
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:15',
            'experience' => 'required|integer|min:0',
            'expertise'  => 'nullable|string|max:255',
            'remark'     => 'nullable|string|max:255',
            'image'      => $id ? 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048' : 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image if updating and previous image exists
            if ($id && $trainer->image) {
                Storage::disk('public')->delete($trainer->image);
            }
            // Upload new image
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            // Keep existing image if no new file is uploaded
            $imagePath = $trainer->image;
        }

        // Assign Form Data
        $trainer->name       = $request->input('name');
        $trainer->email      = $request->input('email');
        $trainer->phone      = $request->input('phone');
        $trainer->experience = $request->input('experience');
        $trainer->expertise  = $request->input('expertise');
        $trainer->remark     = $request->input('remark');
        $trainer->image      = $imagePath;

        // Save Trainer
        $trainer->save();

        return redirect()->route('trainer.index')->with('success', $id ? 'Trainer Updated Successfully!' : 'Trainer Added Successfully!');
    }

    public function delete($id)
    {
        $trainer = Trainer::find($id);
        if (!$trainer) {
            return redirect()->route('trainer.index')->with('error', 'Trainer not found');
        }

        if ($trainer->image) {
            Storage::disk('public')->delete($trainer->image);
        }
        $trainer->delete();

        return redirect()->route('trainer.index')->with('success', 'Trainer Deleted Successfully');
    }
}
