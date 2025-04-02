<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Plan;
use App\Models\Customer\Order;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use App\Models\Admin\AddedPlanFeatures;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::where('status', 'Active')->get();
        $planFeatures = AddedPlanFeatures::with('feature')
            ->get()
            ->groupBy('plan_id')
            ->map(function ($features) {
                return $features->map(function ($addedFeature) {
                    return $addedFeature->feature;
                });
            });

        return view('Customer.Plans.Index', compact('plans', 'planFeatures'));
    }

    public function checkout($id)
    {
        $plan = Plan::findOrFail($id);
        $customer = Auth::user();
            $existingOrder = Order::where('customer_id', $customer->id)
            ->where('status', 'Paid')
            ->first();
        if ($existingOrder) {
            return redirect()->route('customer.plans.index')->with('error', 'You have already purchased this plan.');
        }
        return view('Customer.Plans.Checkout', compact('plan'));
    }

    public function createOrder(Request $request)
    {
        // dd(123);
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'plan_id' => 'required|exists:plans,id',
        ]);
       
        $customer = Auth::user();
        $plan = Plan::findOrFail($request->plan_id);
        
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));


        $order = $api->order->create([
            'receipt' => 'ORDER_' . uniqid(),
            'amount' => $plan->price * 100,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        // dd($order);

        $newOrder = new Order();
        $newOrder->name = $request->name;
        $newOrder->phone = $request->phone;
        $newOrder->email = $request->email;

        $newOrder->customer_id = $customer->id;
        $newOrder->plan_id = $plan->id;
        $newOrder->amount = $plan->price;
        $newOrder->razorpay_order_id = $order['id'];
        $newOrder->status = 'Pending';
        $newOrder->save();

        return view('Customer.Plans.Payment', [
            'order_id' => $order['id'],
            'amount' => $plan->price * 100,
            'key' => env('RAZORPAY_KEY'),
            'plan' => $plan
        ]);
    }
    public function verifyPayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];
            $api->utility->verifyPaymentSignature($attributes);    
            $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();
            $order->razorpay_payment_id = $request->razorpay_payment_id;
            $order->razorpay_signature = $request->razorpay_signature;
            $order->status = 'Paid';
            $order->save();
            $order_id = $order->id; 

            return redirect()->route('customer.purchase.plan', ['order_id' =>$order_id])
            ->with('success', 'Payment successful!');
                    
        } catch (\Exception $e) {
            return redirect()->route('customer.plans.index')->with('error', 'Payment failed! ' . $e->getMessage());
        }
    }

    public function purchaseplan($order_id)
    {
        $order = Order::find($order_id);
        if (!$order) {
            return redirect()->route('customer.plans.index')->with('error', 'Order not found!');
        }
        return view('Customer.Plans.Order', compact('order'));
    }


}
