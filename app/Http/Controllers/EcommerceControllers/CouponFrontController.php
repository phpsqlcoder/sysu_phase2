<?php

namespace App\Http\Controllers\EcommerceControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Helpers\ListingHelper;

use App\EcommerceModel\Coupon;
use App\EcommerceModel\CustomerCoupon;
use App\EcommerceModel\CouponSale;
use App\EcommerceModel\CouponCart;
use App\EcommerceModel\Product;
use App\EcommerceModel\Cart;
use App\Page;
use Auth;

class CouponFrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }

    public function claimed()
    {
        $page = new Page();
        $page->name = 'Claimed Coupons';

        $coupons = CouponSale::where('customer_id',Auth::id())->get();

        return view('theme.sysu.pages.ecommerce.coupons-claimed',compact('page','coupons'));
    }

    public function use_coupon($coupon_id)
    {
        CouponCart::create([
            'customer_id' => Auth::id(),
            'coupon_id' => $coupon_id
        ]);

        return redirect(route('cart.front.show'))->with('success','Coupon successfully place.');
    }

    public function add_manual_coupon(Request $request)
    {

        $coupon = Coupon::where('coupon_code',$request->couponcode)->where('activation_type','manual');

        if($coupon->exists()){
            $c = $coupon->first();

            if($c->status == 'EXPIRED' || $c->status == 'INACTIVE'){
                return response()->json([
                    'expired' => true,               
                ]);
            } else {
                
                CouponCart::create([
                    'customer_id' => Auth::id(),
                    'coupon_id' => $c->id
                ]);

                return response()->json([
                    'success' => true, 
                    'coupon_details' => $c              
                ]);
            }
        } else {
            return response()->json([
                'not_exist' => true,               
            ]);
        }
    }

    public function collectibles(Request $request){
        // Total Purchase Amount
        $couponsMinTotalAmount = Coupon::purchaseMinValue('purchase_amount','purchase_amount_type',$request->total_amount);
        $couponsMaxTotalAmount = Coupon::purchaseMaxValue('purchase_amount','purchase_amount_type',$request->total_amount);
        $couponsExactTotalAmount = Coupon::purchaseExactValue('purchase_amount','purchase_amount_type',$request->total_amount);

        //Total Purchase Quantity
        $couponsMinTotalQty = Coupon::purchaseMinValue('purchase_qty','purchase_qty_type',$request->total_qty);
        $couponsMaxTotalQty = Coupon::purchaseMaxValue('purchase_qty','purchase_qty_type',$request->total_qty);
        $couponsExactTotalQty = Coupon::purchaseExactValue('purchase_qty','purchase_qty_type',$request->total_qty);

        // Purchase within daterange
        // $couponsDateTimePurchase = Coupon::purchaseWithinDateRange();


        // Purchase Products
        $arr_coupons = [];
        $arr_brands = [];
        $arr_products = [];
        $arr_categories = [];

        $cartProducts = Cart::where('user_id',Auth::id())->get();

        // $cartProducts = explode('|',$request->cproducts);

        foreach ($cartProducts as $p) {
            $product = Product::find($p->product_id);

            array_push($arr_products, $p->product_id);
            array_push($arr_categories, $product->category_id);

            if(isset($product->brand)){
                array_push($arr_brands, $product->brand);
            }
        }
        
    // Purchase Product, Category, Brand Only
        $purchasedCoupons = 
            Coupon::where('status','ACTIVE')
            ->where('purchase_combination_counter',1)
            ->where('activation_type','auto')
            ->where(function ($orWhereQuery){
                $orWhereQuery->orwhereNotNull('purchase_product_id')
                      ->orwhereNotNull('purchase_product_cat_id')
                      ->orwhereNotNull('purchase_product_brand');
            })->get();

            foreach ($purchasedCoupons as $coupon) {
                if(isset($coupon->purchase_product_id)){
                    $products   = explode('|',$coupon->purchase_product_id);
                    foreach($products as $prodid){
                        if(in_array($prodid, $arr_products)){
                            array_push($arr_coupons, $coupon->id);
                        }
                    }
                }

                if(isset($coupon->purchase_product_cat_id)){
                    $categories = explode('|',$coupon->purchase_product_cat_id);
                    foreach($categories as $catid){
                        if(in_array($catid, $arr_categories)){
                            array_push($arr_coupons, $coupon->id);
                        }
                    }
                }

                if(isset($coupon->purchase_product_brand)){
                    $brands     = explode('|',$coupon->purchase_product_brand);
                    foreach($brands as $brand){
                        if(in_array($brand, $arr_brands)){
                            array_push($arr_coupons, $coupon->id);
                        }
                    }
                }
            }

            $purchased_coupons = Coupon::whereIn('id',$arr_coupons)->get();
    //

    // Purchase Combination = Product ID or Product Category or Product Brand + total amount + total quantity
        $purchasedCombinationCoupons = 
        Coupon::where('status','ACTIVE')
        ->where('purchase_combination_counter','>',1)
        ->where('activation_type','auto')
        ->where(function ($orWhereQuery){
            $orWhereQuery->orwhereNotNull('purchase_product_id')
              ->orwhereNotNull('purchase_product_cat_id')
              ->orwhereNotNull('purchase_product_brand')
              ->orwhereNotNull('purchase_amount')
              ->orwhereNotNull('purchase_qty');
        })->get();

        $combination_counter = '';
        $arr_purchase_combination_coupons = [];
        foreach($purchasedCombinationCoupons as $coupon){
            $purchasetype = explode('|',$coupon->purchase_combination);

            foreach($purchasetype as $type){
                if($type == 'product'){
                    if(isset($coupon->purchase_product_id)){
                        $products   = explode('|',$coupon->purchase_product_id);
                        foreach($products as $prodid){
                            if(in_array($prodid, $arr_products)){
                                $combination_counter .= 'product|';
                            }
                        }
                    }

                    if(isset($coupon->purchase_product_cat_id)) {
                        $categories = explode('|',$coupon->purchase_product_cat_id);
                        foreach($categories as $catid){
                            if(in_array($catid, $arr_categories)){
                                $combination_counter .= 'product|';
                            }
                        }
                    }

                    if(isset($coupon->purchase_product_brand)) {
                        $brands     = explode('|',$coupon->purchase_product_brand);
                        foreach($brands as $brand){
                            if(in_array($brand, $arr_brands)){
                                $combination_counter .= 'product|';
                            }
                        }
                    }
                }

                if($type == 'amount'){
                    if($coupon->purchase_amount_type == 'min'){
                        if($request->total_amount >= $coupon->purchase_amount){
                            $combination_counter .= 'amount|';
                        }
                    }

                    if($coupon->purchase_amount_type == 'max'){
                        if($request->total_amount <= $coupon->purchase_amount){
                            $combination_counter .= 'amount|';
                        }
                    }
                }

                if($type == 'qty'){
                    $cart = Cart::where('user_id',Auth::id())->where('product_id',$coupon->discount_product_id)->first();
                    if($coupon->purchase_qty_type == 'min'){
                        if($cart->qty >= $coupon->purchase_qty){
                            $combination_counter .= 'qty|';
                        }
                    }

                    if($coupon->purchase_qty_type == 'max'){
                        if($request->total_qty <= $coupon->purchase_qty){
                            $combination_counter .= 'qty|';
                        }
                    }
                }
            }
            
            if($combination_counter == $coupon->purchase_combination){
                $combination_counter = '';
                array_push($arr_purchase_combination_coupons, $coupon->id);
            }
        }

        $purchased_combined_coupons = Coupon::whereIn('id',$arr_purchase_combination_coupons)->get();
        
    //

        $collectibles = collect($couponsMinTotalAmount)
            ->merge($couponsMaxTotalAmount)
            ->merge($couponsExactTotalAmount)
            ->merge($couponsMinTotalQty)
            ->merge($couponsMaxTotalQty)
            ->merge($couponsExactTotalQty)
            ->merge($purchased_coupons)
            ->merge($purchased_combined_coupons);


        $arr_coupon_availability = [];
        foreach($collectibles as $coupon){
            array_push($arr_coupon_availability,$coupon->id);
        }

        $coupons = Coupon::where('status','ACTIVE')->where('activation_type','auto')->where('customer_scope','all');
        if($request->page_name == 'cart'){
            $coupons = $coupons->whereNull('location')->orderBy('name','asc');
            $coupon_customer = Coupon::where('status','ACTIVE')->where('activation_type','auto')->where('customer_scope','specific')->whereNull('location')->get();
        } else {
            $coupons = $coupons->whereIn('amount_discount_type',[1])->where(function ($orWhereQuery){
                $orWhereQuery->orwhereNotNull('location')
                    ->orwhereNotNull('amount')
                    ->orwhereNotNull('percentage');
            })->orderBy('name','asc');

            $coupon_customer = Coupon::where('status','ACTIVE')->where('activation_type','auto')->where('customer_scope','specific')->whereIn('amount_discount_type',[1])->where(function ($orWhereQuery){
                $orWhereQuery->orwhereNotNull('location')
                    ->orwhereNotNull('amount')
                    ->orwhereNotNull('percentage');
            })->get();
        }

        $coupons = $coupons->get();

        $coupon_customer = Coupon::where('status','ACTIVE')->where('activation_type','auto')->where('customer_scope','specific')->get();

        $arr_customer_coupons = [];
        $arr_customer_id = [];
        foreach($coupon_customer as $coupon){
            $customerID = explode('|',$coupon->scope_customer_id);
            foreach($customerID as $id){
                array_push($arr_customer_id, $id);
            }

            if(in_array(Auth::id(), $arr_customer_id)){
                array_push($arr_customer_coupons, $coupon->id);
            }
        }

        if(empty($arr_customer_coupons)){
            $allCoupons = $coupons;
        } else {
            $customerCoupons = Coupon::where('status','ACTIVE')->where('activation_type','auto')->whereIn('id',[$arr_customer_coupons])->get();
            // all or specific coupons
            $allCoupons = collect($customerCoupons)->merge($coupons);
        }

        // get remaining usage
        $arr_coupon_usage_limit = [];
        foreach($allCoupons as $coupon){
            $totalusage = CouponSale::where('coupon_id',$coupon->id)->count();
            $remaining = $coupon->customer_limit-$totalusage;

            array_push($arr_coupon_usage_limit, $remaining);
        }

        return response()->json(['coupons' => $allCoupons, 'availability' => $arr_coupon_availability, 'remaining' => $arr_coupon_usage_limit]);

    }

    public function get_brands(Request $request)
    {
        $categories = explode('|',$request->categories);

        $arr_categories = []; 
        foreach($categories as $category) {
            array_push($arr_categories, $category);
        }

        $brands = Product::whereNotNull('brand')->whereIn('category_id',$arr_categories)->distinct()->get(['brand']);

        if(count($brands)){
            return response()->json(['success' => true, 'brands' => $brands]);
        } else {
            return response()->json(['success' => false]);
        }
        
    }

}
