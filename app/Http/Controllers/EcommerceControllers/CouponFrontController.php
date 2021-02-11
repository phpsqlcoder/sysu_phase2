<?php

namespace App\Http\Controllers\EcommerceControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Helpers\ListingHelper;

use App\EcommerceModel\Coupon;
use App\EcommerceModel\CustomerCoupon;
use App\EcommerceModel\CouponCart;
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

    public function available()
    {
        $page = new Page();
        $page->name = 'Available Coupons';

        $coupons = CustomerCoupon::where('customer_id',Auth::id())->where('usage_status',0)->where('coupon_status','ACTIVE')->get();

        return view('theme.sysu.pages.ecommerce.coupons-available',compact('page','coupons'));
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

}
