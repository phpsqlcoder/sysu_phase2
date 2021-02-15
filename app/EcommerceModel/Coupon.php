<?php

namespace App\EcommerceModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\EcommerceModel\CouponTimeSetting;
use App\EcommerceModel\CouponPurchaseSetting;

class Coupon extends Model
{
	use SoftDeletes;

    protected $fillable = [ 'coupon_code', 'name', 'description', 'terms_and_conditions', 'activation_type', 'customer_scope', 'scope_customer_id', 'location','location_discount_type','location_discount_amount', 'amount', 'percentage', 'free_product_id', 'status', 'start_date', 'end_date', 'start_time', 'end_time', 'event_name', 'event_date', 'repeat_annually', 'purchase_product_id', 'purchase_product_cat_id', 'purchase_product_brand', 'purchase_amount', 'purchase_amount_type', 'purchase_qty', 'purchase_qty_type', 'activity_type', 'customer_limit', 'usage_limit', 'usage_limit_no', 'combination', 'availability', 'user_id'];
    
    public $timestamps = true;

    public static function generate_unique_code()
    {
        $randomString = self::generate_random_string();
        $couponCode = Coupon::where('coupon_code', $randomString)->get();
        while ($couponCode->count()) {
            $randomString = self::generate_random_string();
            $couponCode = Coupon::where('coupon_code', $randomString)->first();
        }

        return $randomString;
    }

    private static function generate_random_string($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function rewards_desc($couponID)
    {
        $coupon = Coupon::find($couponID);

        if(isset($coupon->location)){
            return 
            '<tr>
                <td>Coupon Reward: Free Shipping</td>
                <td></td>
            </tr>';
        }

        if(isset($coupon->amount)){
            return 
            '<tr>
                <td>LESS : Discount Amount</td>
                <td align="right">&#8369; '.$coupon->amount.'</td>
            </tr>';
        }
    }

     public static function coupon_reward($couponID)
     {
        $coupon = Coupon::find($couponID);

        if(isset($coupon->amount)){
            $reward =  $coupon->amount;
        }

        return $reward;
     }
}
