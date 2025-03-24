<?php

namespace App\Models\Customer;

use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use App\Models\Admin\Flavor;
use App\Models\Admin\ProductFlavor;
use App\Models\Admin\ProductFlavorSize;
use Illuminate\Database\Eloquent\Model;

class Product_Order_Item extends Model
{
    protected $table = 'product_order_item';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_flavor_id',
        'product_flavor_size_id',
        'qty',
        'total_price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productFlavor()
    {
        return $this->belongsTo(ProductFlavor::class);
    }

    public function productFlavorSize()
    {
        return $this->belongsTo(ProductFlavorSize::class);
    }
}
