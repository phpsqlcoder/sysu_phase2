<?php

namespace App\Helpers\Webfocus;
use App\EcommerceModel\Cart;
use App\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Setting {

    public static function info() {

        $setting = DB::table('settings')->first();
        $setting->menu = DB::table('menus')->where('is_active', 1)->first();
        return $setting;

	}

	public static function getFaviconLogo()
    {
        $settings = DB::table('settings')->where('id',1)->first();

        return $settings;
    }

    public static function social_account($sm)
    {
        $account = DB::table('social_media')->where('name','=',$sm)->first();

        if($account === null){
            return false;
        }
        else{
            return $account;
        }

    }

    public static function getFooter()
    {
        $delete_old_entries = \App\EcommerceModel\Cart::where('updated_at','<',Carbon::now()->subDays(2))->delete();
        $old_sales = \App\EcommerceModel\SalesHeader::where('updated_at','<',Carbon::now()->subDays(2))->whereStatus('active')->get();
        foreach($old_sales as $s){
             $paid = \App\EcommerceModel\SalesPayment::where('sales_header_id',$s->id)->whereStatus('PAID')->sum('amount');
             if($paid<=0){
                $cancel_sales = \App\EcommerceModel\SalesHeader::whereId($s->id)->update([
                    'deleted_at' => date('Y-m-d H:i:s'),
                    'status' => 'CANCELLED',
                    'delivery_status' => 'CANCELLED'
                ]);
             }
        }
;
        
        $footer = DB::table('pages')->where('slug', 'footer')->where('name', 'footer')->first();

        return $footer;
    }

    public function delete_old_records(){

    }

    public static function date_for_listing($date) {
        if ($date == null || trim($date) == '') {
            return "-";
        }
        else if ($date != null && strtotime($date) < strtotime('-1 day')) {
            return Carbon::parse($date)->isoFormat('lll');
        }

        return Carbon::parse($date)->diffForHumans();
	}

    public static function date_for_news_list($date) {
        if ($date != null && strtotime($date) > strtotime('-1 day')) {
            return Carbon::parse($date)->toFormattedDateString();
        } else {
            return 'on '.date('M d, Y', strtotime($date));
        }
    }


    public function social($page,$account){
    	if($page == 'facebook')
    		return '
				jsSocials.shares.facebook = {
	                logo: "fa fa-facebook-f",
	                shareUrl: "https://facebook.com/'.$account.'",
	                getCount: function(data) {
	                    return data.count;
	                }
	            };
    		';
    	elseif($page == 'twitter')
    		return '
				jsSocials.shares.twitter = {
	                logo: "fa fa-twitter",
	                shareUrl: "https://twitter.com/'.$account.'",
	                getCount: function(data) {
	                    return data.count;
	                }
	            };
    		';
    	elseif($page == 'instagram')
    		return '
				jsSocials.shares.instagram = {
	                logo: "fa fa-instagram",
	                shareUrl: "https://instagram.com/'.$account.'",
	                getCount: function(data) {
	                    return data.count;
	                }
	            };
    		';
    	elseif($page == 'google')
    		return '
				jsSocials.shares.googleplus = {
	                logo: "fa fa-google-plus",
	                shareUrl: "https://plus.google.com/'.$account.'",
	                getCount: function(data) {
	                    return data.count;
	                }
	            };
    		';
    	elseif($page == 'dribble')
    		return '
				jsSocials.shares.dribbble = {
	                logo: "fa fa-dribbble",
	                shareUrl: "https://dribbble.com/'.$account.'",
	                getCount: function(data) {
	                    return data.count;
	                }
	            };
    		';
    }

    public static function get_company_logo_storage_path()
    {
        $settings = DB::table('settings')->where('id',1)->first();

        return asset('storage').'/logos/'.$settings->company_logo;
    }

    public static function get_company_favicon_storage_path()
    {
        $settings = DB::table('settings')->where('id',1)->first();

        return asset('storage').'/icons/'.$settings->website_favicon;
    }

    public static function EcommerceCartTotalItems()
    {
        if (\Auth::check()) {
            return Cart::total_items_of_auth_cart();
        } else {
            return Cart::total_items_of_guest_cart();
        }
    }

    public static function belowReorderTotal()
    {
        $products = \App\EcommerceModel\Product::all();
        $x = 0;
        foreach($products as $product){
            if($product->reorder_point > 0 && $product->Inventory <= $product->reorder_point){
                $x++;           
            }
        }

        return $x;
    }

    public static function outOfStockTotal()
    {
        $products = \App\EcommerceModel\Product::all();
        $x = 0;
        foreach($products as $product){
            if($product->Inventory <= 0){
                $x++;           
            }
        }

        return $x;
    }

    public static function EcommerceCartTotalProductPrice() //
    {
        if (\Auth::check()) {
            $cart = Cart::where('user_id', auth()->id())->get();
        } else {
            $cart = session('cart', []);
        }

        $totalCost = 0;
        foreach($cart as $order) {
            $totalCost += $order->price * $order->qty;
        }

        return $totalCost;
    }

    public static function paynamics_merchant()
    {
        if (env('APP_ENV') == 'production') {
        
           return [
                'id' => '0000000806200B898D54',
                'key' => 'E40BE25D0BAA86AD45A046ADB00CB9CE',
                'url' => 'https://ptiapps.paynamics.net/webpayment/Default.aspx'
            ];
        
          /* 
            return [
                'id' => '00000019121943FC3BD7',
                'key' => '6B1198B811715D83148DB4E7FC981A54',
                'url' => 'https://testpti.payserv.net/webpayment/Default.aspx'
            ];
            */
            
        } else {
            return [
                'id' => '00000019121943FC3BD7',
                'key' => '6B1198B811715D83148DB4E7FC981A54',
                'url' => 'https://testpti.payserv.net/webpayment/Default.aspx'
            ];
        }
    }
}
