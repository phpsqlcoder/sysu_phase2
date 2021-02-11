<?php

namespace App\Http\Controllers\EcommerceControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Helpers\ListingHelper;


use App\EcommerceModel\Coupon;
use App\EcommerceModel\Product;
use App\EcommerceModel\ProductCategory;
use App\User;


use Auth;

class CouponController extends Controller
{
    private $searchFields = ['name'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listing = new ListingHelper('desc', 10, 'updated_at');

        $coupons = $listing->simple_search(Coupon::class, $this->searchFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.coupon.index',compact('coupons', 'filter', 'searchType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('status','PUBLISHED')->get();
        $categories =  ProductCategory::where('status','PUBLISHED')->get();
        $brands = Product::distinct()->get(['brand']);
        $customers = User::where('role_id',6)->where('is_active',1)->get();

        return view('admin.coupon.create',compact('products','categories','brands','customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|max:150',
            'description' => 'required',
            'reward' => 'required'
        ])->validate();

        $coupon = Coupon::create([
            'coupon_code' => Coupon::generate_unique_code(),
            'name' => $request->name,
            'description' => $request->description,
            'terms_and_conditions' => $request->terms,
            'activation_type' => $request->coupon_activation[0],
            'customer_scope' => $request->coupon_scope,
            'scope_customer_id' => $request->coupon_scope == 'specific' ? $request->customer : NULL,
            'location' => $request->reward == 'free-shipping-optn' ? $request->location : NULL,
            'amount' => $request->reward == 'discount-amount-optn' ? $request->discount_amount : NULL,
            'percentage' => $request->reward == 'discount-percentage-optn' ? $request->discount_percentage : NULL,
            'gift_name' => $request->reward == 'free-gift-optn' ? $request->gift_name : NULL,
            'free_product_id' => $request->free_product_id,
            // 'upgrade_product_id' => $request->update_product_id,
            'status' => ($request->has('status') ? 'ACTIVE' : 'INACTIVE'),
            'user_id' => Auth::id(),
        ]);

        if($coupon){

            $this->update_coupon_time_settings($coupon->id,$request);            
            $this->update_coupon_purchase_settings($coupon->id,$request);
            // $this->update_coupon_activity_settings($coupon->id,$request);
            $this->update_coupon_rule_settings($coupon->id,$request);
        }
        

        return redirect(route('coupons.index'))->with('success','Coupon has been added.');
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
        $products = Product::where('status','PUBLISHED')->get();
        $categories =  ProductCategory::where('status','PUBLISHED')->get();
        $brands = Product::distinct()->get(['brand']);
        $customers = User::where('role_id',6)->where('is_active',1)->get();

        return view('admin.coupon.edit',compact('coupon','products','categories','brands','customers'));
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
        Coupon::find($coupon->id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'terms_and_conditions' => $request->terms,
            'activation_type' => $request->coupon_activation[0],
            'customer_scope' => $request->coupon_scope,
            'scope_customer_id' => $request->coupon_scope == 'specific' ? $request->customer : NULL,
            'location' => $request->reward == 'free-shipping-optn' ? $request->location : NULL,
            'amount' => $request->reward == 'discount-amount-optn' ? $request->discount_amount : NULL,
            'percentage' => $request->reward == 'discount-percentage-optn' ? $request->discount_percentage : NULL,
            'gift_name' => $request->reward == 'free-gift-optn' ? $request->gift_name : NULL,
            'free_product_id' => $request->free_product_id,
            // 'upgrade_product_id' => $request->update_product_id,
            'status' => ($request->has('status') ? 'ACTIVE' : 'INACTIVE'),
            'user_id' => Auth::id(),
        ]);

        if($coupon){
            
            $this->update_coupon_time_settings($coupon->id,$request);            
            $this->update_coupon_purchase_settings($coupon->id,$request);
            // $this->update_coupon_activity_settings($coupon->id,$request);
            $this->update_coupon_rule_settings($coupon->id,$request);
        }

        return back()->with('success','Coupon details has been updated.');
    }

    public function update_coupon_time_settings($couponID,$request)
    {
        Coupon::find($couponID)->update([
            'start_date' => $request->coupon_time[0] == 'datetime' ? $request->startdate : NULL,
            'end_date' => $request->coupon_time[0] == 'datetime' ? $request->enddate : NULL,
            'start_time' => $request->coupon_time[0] == 'datetime' ? $request->starttime : NULL,
            'end_time' => $request->coupon_time[0] == 'datetime' ? $request->endtime : NULL,
            'event_name' => $request->coupon_time[0] == 'custom' ? $request->eventname : NULL,
            'event_date' => $request->coupon_time[0] == 'custom' ? $request->eventdate : NULL,
            'repeat_annually' => $request->has('repeat_annually') ? 1 : 0,
        ]);
    }

    public function update_coupon_purchase_settings($couponID,$request)
    {   
        $data = $request->all();

        $productnames = '';
        if(isset($request->product_name)){
            $prodname = $data['product_name'];
            foreach($prodname as $prod){
                $productnames .= $prod.'|';
            }
        }

        $productcategories = '';
        if(isset($request->product_category)){
            $prodcat = $data['product_category'];

            
            foreach($prodcat as $cat){
                $productcategories .= $cat.'|';
            }
        }

        $productbrand = '';
        if(isset($request->product_brand)){
            $prodbrand = $data['product_brand'];
            foreach($prodbrand as $brand){
                $productbrand .= $brand.'|';
            }
        }

        Coupon::find($couponID)->update([
            'purchase_product_id' => $request->coupon_purchase[0] == 'product' ? $productnames : NULL,
            'purchase_product_cat_id' => $request->coupon_purchase[0] == 'product' ? $productcategories : NULL,
            'purchase_product_brand' => $request->coupon_purchase[0] == 'product' ? $productbrand : NULL,
            'purchase_amount' => $request->coupon_purchase[0] == 'amount' ? $request->purchase_amount : NULL,
            'purchase_amount_type' => $request->coupon_purchase[0] == 'amount' ? $request->amount_opt : NULL,
            'purchase_qty' =>  $request->coupon_purchase[0] == 'qty' ? $request->purchase_qty : NULL,
            'purchase_qty_type' =>  $request->coupon_purchase[0] == 'qty' ? $request->qty_opt : NULL
        ]);
    }

    // public function update_coupon_activity_settings($couponID,$request)
    // {
    //     Coupon::find($couponID)->update([
    //         'activity_type' => $request->coupon_activity[0],
    //         'org_name' => $request->coupon_activity[0] == 'feat_organization' ? $request->org_name : NULL,
    //         'inactive_no' => $request->coupon_activity[0] == 'returning_customer' ? $request->inactive_no : NULL,
    //         'inactive_type' => $request->coupon_activity[0] == 'returning_customer' ? $request->coupon_return_customer : NULL,
    //     ]);
    // }

    public function update_coupon_rule_settings($couponID,$request)
    {
        Coupon::find($couponID)->update([
            'customer_limit' => $request->coupon_rule[0] == 'customer_limit' ? $request->coupon_customer_limit_qty : NULL,
            'usage_limit' => isset($request->usage_limit[0]) ? $request->usage_limit[0] : NULL,
            'usage_limit_no' => $request->usage_limit[0] == 'multiple_use' ? $request->multi_usage_limit_qty : NULL,
            'transaction_limit' => isset($request->coupon_rule[2]) && $request->coupon_rule[2] == 'transaction_limit' ? $request->coupon_transac_limit[0] : NULL,
        ]);
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

    public function update_status($id,$status)
    {
        Coupon::find($id)->update([
            'status' => $status,
            'user_id' => Auth::id()
        ]);

        return back()->with('success', __('standard.coupons.status_update_success', ['STATUS' => $status]));
    }

    public function single_delete(Request $request)
    {
        $coupon = Coupon::findOrFail($request->coupons);
        $coupon->update([ 'user' => Auth::id() ]);
        $coupon->delete();

        return back()->with('success', __('standard.coupons.single_delete_success'));
    }

    public function restore($coupon){
        Coupon::withTrashed()->find($coupon)->update(['status' => 'INACTIVE','user_id' => Auth::id() ]);
        Coupon::whereId($coupon)->restore();

        return back()->with('success', __('standard.coupons.restore_promo_success'));
    }

    public function multiple_change_status(Request $request)
    {
        $coupons = explode("|", $request->coupons);

        foreach ($coupons as $coupon) {
            $publish = Coupon::where('status', '!=', $request->status)->whereId($coupon)->update([
                'status'  => $request->status,
                'user_id' => Auth::id()
            ]);
        }

        return back()->with('success',  __('standard.coupons.multiple_status_update_success', ['STATUS' => $request->status]));
    }

    public function multiple_delete(Request $request)
    {
        $coupons = explode("|",$request->coupons);

        foreach($coupons as $coupon){
            Coupon::whereId($coupon)->update(['user_id' => Auth::id() ]);
            Coupon::whereId($coupon)->delete();
        }

        return back()->with('success', __('standard.coupons.multiple_delete_success'));
    }

}