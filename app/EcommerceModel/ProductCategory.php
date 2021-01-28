<?php

namespace App\EcommerceModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    public $table = 'product_categories';
    protected $fillable = [ 'parent_id', 'name', 'slug', 'description', 'status', 'created_by',];

    public function get_url()
    {
        return env('APP_URL')."/product-categories/".$this->slug;
    }

    public function child_categories() {
        return  $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function  published_products()
    {
        return $this->hasMany(Product::class, 'category_id')->where('status','PUBLISHED');
    }

    public function featured_products()
    {
        return $this->products()->where('is_featured', 1)->get();
    }
}
