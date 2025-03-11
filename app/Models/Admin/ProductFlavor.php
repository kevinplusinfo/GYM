<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFlavor extends Model

{


    protected $table = 'product_flavor'; 

    protected $fillable = ['product_id', 'flavor_id']; 

    public function sizes()
    {
        return $this->hasMany(ProductFlavorSize::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

   

    public function flavor()
    {
        return $this->belongsTo(Flavor::class, 'flavor_id');
    }

}
