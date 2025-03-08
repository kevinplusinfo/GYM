<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Flavor;

class AdminFlavorController extends Controller
{
    public function index()
    {
        $flavors = Flavor::all();
        return view('Admin.Ecom.Flavor', compact('flavors'));
    }

    public function form($id = null)
    {
        $flavor = $id ? Flavor::findOrFail($id) : null;
        return view('Admin.Ecom.AddFlavor', compact('flavor'));
    }

    public function save(Request $request, $id = null)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:flavors,name,' . ($id ?? 'NULL') . ',id',
        ]);

        Flavor::updateOrCreate(
            ['id' => $id],
            ['name' => $request->name]
        );

        return redirect()->route('flavors.index')->with('success', $id ? 'Flavor updated successfully.' : 'Flavor added successfully.');
    }

    public function destroy($id)
    {
        Flavor::findOrFail($id)->delete();
        return redirect()->route('flavors.index')->with('success', 'Flavor deleted successfully.');
    }
}
