<?php

namespace App\Models\Customer;
use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use App\Models\Admin\Flavor;
use App\Models\Admin\ProductFlavor;
use App\Models\Admin\ProductFlavorSize;
use Illuminate\Database\Eloquent\Model;

class Product_Order extends Model
{
    protected $table = 'product_order';

    protected $fillable = [
        'customer_id',
        'order_no',
        'razorpay_order_id',
        'payment_id',
        'razorpay_signature',
        'payment_status',
        'name',
        'phone',
        'address',
        'zipcode',
        'city',
        'state',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


}
