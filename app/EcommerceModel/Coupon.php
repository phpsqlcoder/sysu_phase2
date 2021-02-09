<?php

namespace App\EcommerceModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\EcommerceModel\CouponTimeSetting;
use App\EcommerceModel\CouponPurchaseSetting;

class Coupon extends Model
{
	use SoftDeletes;

    protected $fillable = [ 'name', 'description', 'terms_and_conditions', 'activation_type', 'customer_scope', 'scope_customer_name', 'location', 'amount', 'percentage', 'gift_name', 'free_product_id', 'upgrade_product_id', 'status', 'start_date', 'end_date', 'start_time', 'end_time', 'event_name', 'event_date', 'repeat_annually', 'purchase_product_id', 'purchase_product_cat_id', 'purchase_product_brand', 'purchase_amount', 'purchase_amount_type', 'purchase_qty', 'purchase_qty_type', 'activity_type', 'org_name', 'inactive_no', 'inactive_type', 'customer_limit', 'usage_limit', 'usage_limit_no', 'transaction_limit', 'user_id'];
    
    public $timestamps = true;
}
