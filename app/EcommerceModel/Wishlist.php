<?php

namespace App\EcommerceModel;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Wishlist extends Model
{
    public $table = 'wishlist';
    public $fillable = ['product_id','product_name','total_count'];
    protected $timestamp = true;

    public function product_details()
    {
        return $this->belongsTo('\App\EcommerceModel\Product','product_id');
    }

    public function wishlist_customer()
    {
        return $this->hasMany('\App\EcommerceModel\CustomerWishlist','product_id','product_id');
    }
}
