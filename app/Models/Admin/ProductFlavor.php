<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductFlavor extends Model
{
    protected $table = 'product_flavor'; 

    protected $fillable = ['product_id', 'flavor_id']; 

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function flavor()
    {
        return $this->belongsTo(Flavor::class, 'flavor_id');
    }

    public function sizes()
    {
        return $this->hasMany(ProductFlavorSize::class, 'product_flavor_id');
    }

}
