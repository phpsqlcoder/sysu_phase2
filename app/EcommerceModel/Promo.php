<?php

namespace App\EcommerceModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;
class Promo extends Model
{
	use SoftDeletes;

    protected $fillable = [ 'name', 'promo_start', 'promo_end', 'discount', 'status', 'is_expire', 'user_id', 'type', 'discount_type'];
    public $timestamps = true;

    public function products()
    {
    	return $this->hasMany('\App\EcommerceModel\PromoProducts','promo_id');
    }

    public static function promo_percentage($productid)
    {
        // $promo = DB::table('promos')->join('promo_products','promos.id','=','promo_products.promo_id')->where('promos.status','ACTIVE')->where('promos.is_expire',0)->where('promo_products.product_id',$productid);

        $promo = DB::table('promos')->select('promos.discount','promos.discount_type')->join('promo_products','promos.id','=','promo_products.promo_id')->where('promos.status','ACTIVE')->where('promos.is_expire',0)->where('promo_products.product_id',$productid);

        
        if($promo->count() > 0){
            $query = $promo->orderBy('discount','desc')->first();

            if($query->discount_type == 'amount'){
                $discount['discount'] = $query->discount;
                $discount['text'] = 'Php '.$query->discount;
            } else {
                $discount['discount'] = $query->discount;
                $discount['text'] = $query->discount.'%';
            }

        } else {
            $discount['discount'] = 0;
        }

        return $discount;
    }
}
