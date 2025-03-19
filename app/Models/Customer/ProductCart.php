<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use App\Models\Admin\Flavor;
use App\Models\Admin\ProductFlavor;
use App\Models\Admin\ProductFlavorSize;
// use App\Models\Customer\ProductCart;

class ProductCart extends Model
{
    
        protected $table = "product_cart";
    
        protected $fillable = [
            'customer_id', 
            'product_id', 
            'productflavor_id', 
            'productflavorsize_id', 
            'qty'
        ];
    
        public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productFlavor()
    {
        return $this->belongsTo(ProductFlavor::class, 'productflavor_id');
    }

    public function productFlavorSize()
{
    return $this->belongsTo(ProductFlavorSize::class, 'productflavorsize_id', 'id');
}

}
    

