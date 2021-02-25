<?php

namespace App\EcommerceModel;
use Illuminate\Database\Eloquent\Model;

use App\EcommerceModel\Coupon;
use App\EcommerceModel\SalesHeader;

class CouponSale extends Model
{
	protected $table = "coupon_sales";
    protected $fillable = [ 'customer_id', 'coupon_id', 'coupon_code', 'sales_header_id', 'order_status'];
    public $timestamps = true;

    public function details()
    {
    	return $this->belongsTo(Coupon::class,'coupon_id');
    }

    public function sales_details()
    {
    	return $this->belongsTo(SalesHeader::class,'sales_header_id');
    }
}
