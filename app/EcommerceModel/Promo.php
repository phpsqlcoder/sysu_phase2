<?php

namespace App\EcommerceModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
	use SoftDeletes;

    protected $fillable = [ 'name', 'promo_start', 'promo_end', 'discount', 'status', 'is_expire', 'user_id', 'type'];
    public $timestamps = true;

    public function products()
    {
    	return $this->hasMany('\App\EcommerceModel\PromoProducts','promo_id');
    }

    public static function update_promo_xpiration()
    {
    	$promos = Promo::where('status','ACTIVE')->where('is_expire',0)->get();

    	foreach($promos as $promo){
    		if($promo->promo_end <= now()){
    			Promo::find($promo->id)->update(['is_expire' => 1]);
    		}
    	}
    }
}
