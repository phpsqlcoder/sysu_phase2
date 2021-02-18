<?php

namespace App\EcommerceModel;
use Illuminate\Database\Eloquent\Model;

class CouponSale extends Model
{
	protected $table = "coupon_sales";
    protected $fillable = [ 'customer_id', 'coupon_id', 'sales_header_id'];
    public $timestamps = true;
}
