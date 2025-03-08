<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Flavor extends Model
{
    protected $fillable = ['name'];
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_flavor', 'flavor_id', 'product_id');
    }
    public function productFlavorSizes()
    {
        return $this->hasMany(ProductFlavorSize::class, 'flavor_id');
    }
}
