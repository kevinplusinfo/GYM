<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\{
    Flavor
};
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'description', 'specifiaction', 'main_image'];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function flevor()
    {
        return $this->hasMany(Flavor::class, 'product_id', 'id');    
    }

    public function flavors()
    {
        return $this->hasMany(ProductFlavor::class);
    }
    public function productFlavors()
    {
        return $this->hasMany(ProductFlavor::class, 'product_id');
    }
    public function flavorSizes()
    {
        return $this->hasManyThrough(ProductFlavorSize::class, ProductFlavor::class, 'product_id', 'product_flavor_id');
    }

}
