<?php

namespace App\EcommerceModel;

use Illuminate\Database\Eloquent\Model;
use App\EcommerceModel\Coupon;

class CouponCart extends Model
{
	protected $table = 'coupon_cart';
    protected $fillable = [ 'coupon_id','customer_id'];
    public $timestamps = true;

    public function details()
    {
    	return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
