<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PlanFeature;
use Illuminate\Http\Request;

class PlanFeatureController extends Controller
{
    public function index(Request $request)
    {
        $feature = PlanFeature::orderByDesc('id')->paginate(30);
        return view('Admin.Plan.Feature', compact('feature'));
    }

    public function add(Request $request, $id = null)
    {
        if ($id) {
            $feature = PlanFeature::findOrFail($id);
            $feature->update($request->only('name'));
            return redirect()->route('Feature.plan')->with('success', 'Feature updated successfully.');
        }

        PlanFeature::create($request->only('name'));
        return redirect()->route('Feature.plan')->with('success', 'Feature added successfully.');
    }

    public function delete($id)
    {
        $feature = PlanFeature::findOrFail($id);
        $feature->delete();
        return redirect()->route('Feature.plan')->with('success', 'Feature deleted successfully.');
    }
}
