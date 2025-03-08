<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductFlavorSize extends Model
{
    protected $fillable = ['product_flavor_id', 'weight', 'price', 'qty', 'strike_price'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function flavor()
    {
        return $this->belongsTo(Flavor::class, 'flavor_id');
    }
    public function productFlavor()
    {
        return $this->belongsTo(ProductFlavor::class, 'product_flavor_id');
    }
}
