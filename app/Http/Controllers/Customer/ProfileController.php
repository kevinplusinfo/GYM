<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;
use App\Models\Customer\Order;
use App\Models\Customer\Product_Order;



class ProfileController extends Controller
{
    public function index()
    {
        $order = Order::select('id')
                        ->where('customer_id', Auth::id())
                        ->first();
        $product_orderIds = Product_Order::where('customer_id', Auth::id())->pluck('id')->first();

        // dd($product_orderIds);                   
        return view('Customer.Profile.Profile', compact('order','product_orderIds'));
    }

    public function update(Request $request)
    {
        $customer = Auth::user();
    
        $rules = [
            'name' => 'required|string|max:255',
            'mno' => 'required|string|max:10|min:10',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'newpassword' => 'nullable|min:5|confirmed',
        ];
    
        if ($request->filled('newpassword')) {
            $rules['current_password'] = 'required';
        }
    
        $request->validate($rules);
    
        // If the user wants to update the password
        if ($request->filled('newpassword')) {
            if (!Hash::check($request->current_password, $customer->password)) {
                return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }
            $customer->password = Hash::make($request->newpassword);
        }
    
        $customer->name = $request->name;
        $customer->mno = $request->mno;
        $customer->email = $request->email;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            if ($customer->profile_image && Storage::exists('public/' . $customer->profile_image)) {
                Storage::delete('public/' . $customer->profile_image);
            }
    
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('images', $imageName, 'public');
    
            $customer->profile_image = $path;
        }
    
        $customer->save();
    
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
