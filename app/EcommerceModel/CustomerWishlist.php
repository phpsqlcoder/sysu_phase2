<?php

namespace App\EcommerceModel;

use Illuminate\Database\Eloquent\Model;
use Auth;

class CustomerWishlist extends Model
{
    public $table = 'customer_wishlist';
    public $fillable = ['product_id','customer_id'];
    protected $timestamp = true;

    public function customer_details()
    {
    	return $this->belongsTo('\App\User','customer_id');
    }

    // public static function product_wishlist($id)
    // {
    // 	$count = CustomerWishlist::where('customer_id',Auth::id())->where('product_id',$id)->count();

    // 	return $count;
    // }

    public static function is_wishlist($id)
    {
        $count = CustomerWishlist::where('customer_id',Auth::id())->where('product_id',$id)->count();

        return $count;
    }


    public function product_details()
    {
        return $this->belongsTo('\App\EcommerceModel\Product','product_id');
    }
}
