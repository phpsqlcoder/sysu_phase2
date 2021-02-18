<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\EcommerceModel\Cart;
use App\Mail\SalesCompleted;
use Illuminate\Support\Facades\Mail;
use App\EcommerceModel\SalesPayment;
use App\EcommerceModel\SalesHeader;
use App\EcommerceModel\SalesDetail;
use App\Helpers\Webfocus\Setting;
use App\EcommerceModel\Product;
use App\EcommerceModel\Coupon;
use App\EcommerceModel\CustomerCoupon;
use App\EcommerceModel\CouponCart;
use App\EcommerceModel\CouponSale;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\PaynamicsLog;
use App\Helpers\PaynamicsHelper;
use App\Page;
use Auth;
use Redirect;
use DateTime;
use Carbon\Carbon;

use DB;


class CartController extends Controller
{
    public function store(Request $request)
    {       
        $product = Product::whereId($request->product_id)->first();

        $promo = DB::table('promos')->join('promo_products','promos.id','=','promo_products.promo_id')->where('promos.status','ACTIVE')->where('promos.is_expire',0)->where('promo_products.product_id',$request->product_id);

        if($promo->count() > 0){
            $discount = $promo->max('promos.discount');

            $percentage = ($discount/100);
            $discountedAmount = ($product->price * $percentage);

            $price = number_format(($product->price - $discountedAmount),2,'.','');
        } else {
            $price = number_format($product->price,2,'.','');
        }


        // logger($request);
        // return;
        if (auth()->check()) {
            
            $cart = Cart::where('product_id', $request->product_id)
                ->where('user_id', Auth::id())
                ->first();

            if (!empty($cart)) {
                //$newQty = $cart->qty + $request->qty;
                $newQty = $request->qty;
                $save = $cart->update([
                    'qty' => $newQty,
                    'price' => $price
                ]);
            } else {
                $save = Cart::create([
                    'product_id' => $request->product_id,
                    'user_id' => Auth::id(),
                    'qty' => $request->qty,
                    'price' => $price
                ]);
            }

        } 
        else 
        {
            $cart = session('cart', []);
            $not_exist = true;

            foreach ($cart as $key => $order) {
                if ($order->product_id == $request->product_id) {
                    $cart[$key]->qty = $request->qty;
                    $cart[$key]->price = $price;
                    $not_exist = false;
                    break;
                }
            }

            if ($not_exist) {
                $order = new Cart();
                $order->product_id = $request->product_id;
                $order->qty = $request->qty;
                $order->price = $price;

                array_push($cart, $order);
            }

            session(['cart' => $cart]);
           

        }
       
        $inventory_remark = true;

        if($inventory_remark){
            return response()->json([
                'success' => true,
                'totalItems' => Setting::EcommerceCartTotalItems()                
            ]);
            
        }else{
            return response()->json([
                'success' => false,
                'totalItems' => Setting::EcommerceCartTotalItems()                
            ]);
        }
    }

    public function view()
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id',Auth::id())->get();
            $totalProducts = $cart->count();

            $customerCoupons = 
                CustomerCoupon::join('coupons','customer_coupons.coupon_id','=','coupons.id')
                ->select('customer_coupons.*','coupons.amount','coupons.percentage','coupons.amount_discount_type')
                ->where(function ($query){
                    $query->orwhereNotNull('coupons.amount')
                    ->orwhereNotNull('coupons.percentage');
                })->where('customer_id',Auth::id())->where('customer_coupons.coupon_status','ACTIVE')->get();

            // OrderTotal Amount and Quantity 
            $totalAmount = 0;
            $totalQty = 0;
            foreach($cart as $c){
                $totalAmount += $c->product->discountedprice*$c->qty;
                $totalQty += $c->qty;
            }


        } else {
            $cart = session('cart', []);
            $totalProducts = count(session('cart', []));
            
            $customerCoupons = '';
        }

        $page = new Page();
        $page->name = 'Cart';



        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.cart.cart', compact('cart', 'totalProducts','customerCoupons','page'));
    }

    public function remove_product(Request $request)
    {

        if (auth()->check()) {
            $delete = Cart::whereId($request->product_remove_id)->delete();
        } else {
            $cart = session('cart', []);
            $index = (int) $request->product_remove_id;
            if (isset($cart[$index])) {
                unset($cart[$index]);
            }
            session(['cart' => $cart]);
        }

        return back();
    }


    public function ajax_update(Request $request)
    {
        if (auth()->check()) {            
            if (Cart::where('user_id', auth()->id())->count() == 0) {
                return;
            }
            $upd = Cart::where('product_id',$request->record_id)->where('user_id', auth()->id())->update([
                'qty' => $request->quantity
            ]);
        } else {
            $cart = session('cart', []);
                foreach ($cart as $key => $order) {
                    if ($order->product_id == $request->record_id) {
                        $cart[$key]->qty = $request->quantity;
                        break;
                    }
                }
            session(['cart' => $cart]);
        }

        return response()->json([
            'success' => true               
        ]);
    }

    public function batch_update(Request $request)
    {
        if (auth()->check()) {            
            if (Cart::where('user_id', auth()->id())->count() == 0) {
                return redirect()->route('product.front.list');
            }

            for ($x = 1; $x <= $request->total_products; $x++) {
                $upd = Cart::whereId($request->record_id[$x])->where('user_id', auth()->id())->update([
                    'qty' => $request->quantity[$x]
                ]);
              
            }

            $refreshCustomerCouponCart = CouponCart::where('customer_id',Auth::id())->delete();
            if($request->coupon_counter > 0){
                $data = $request->all();
                $coupons = $data['couponid'];
                $product = $data['coupon_productid'];

                foreach($coupons as $key => $coupon){
                    CouponCart::create([
                        'coupon_id' => $coupon,
                        'product_id' => $product[$key] == 0 ? NULL : $product[$key],
                        'customer_id' => Auth::id()
                    ]);
                }
            }
            
            return redirect()->route('cart.front.checkout');
        } else {
            $cart = session('cart', []);

            for ($x = 1; $x <= $request->total_products; $x++) {
                foreach ($cart as $key => $order) {
                    if ($order->product_id == $request->record_id[$x]) {
                        $cart[$key]->qty = $request->quantity[$x];
                        break;
                    }
                }
            }

            session(['cart' => $cart]);

            return redirect()->route('customer-front.login');
        }
    }

    public function pay_again($id){
        $r = SalesHeader::findOrFail($id);

        $sales = 
        $urls = [
            'notification' => route('cart.payment-notification'),
            'result' => route('profile.sales'),
            'cancel' => route('profile.sales'),
        ];
       
        $base64Code = PaynamicsHelper::payNow($r->order_number, Auth::user(), $r->items, number_format($r->net_amount, 2, '.', ''), $urls, false ,number_format($r->delivery_fee_amount, 2, '.', ''));
         return view('theme.paynamics.sender', compact('base64Code'));
    }

    public function next_order_number(){
        $last_order = SalesHeader::whereDate('created_at', Carbon::today())->orderBy('created_at','desc')->first();
        if(empty($last_order)){
            $next_number = date('Ymd')."-0001";
        }
        else{
            $order_number = explode("-",$last_order->order_number);
            if(!isset($order_number[1])){
                $next_number = date('Ymd')."-0001";
            }
            else{

                $next_number = date('Ymd')."-".str_pad(($order_number[1] + 1), 4, '0', STR_PAD_LEFT);
            }
        }
        return $next_number;
    }

    public function save_sales(Request $request) { 

        $total_cart_items = Cart::where('user_id',Auth::id())->count();
        if($total_cart_items == 0){
            return redirect()->route('profile.sales');
        }
        $customer_delivery_adress = $request->delivery_address ?? ' ';
        $customer_name = Auth::user()->fullName;
        $customer_contact_number =  $request->mobile ?? Auth::user()->mobile;
           
        if(isset($request->deductedAmount)){
            $totalPrice = ($request->total_amount-$request->deductedAmount);
        } else {
            $totalPrice = $request->total_amount;
        }
        
        // $ran = microtime();
        // $today = getdate();
        //$requestId = $today[0].substr($ran, 2,6);  
        $requestId = $this->next_order_number();  
 
        $member = Auth::user();
              
        $salesHeader = SalesHeader::create([
            'user_id' => auth()->id(),
            'order_number' => $requestId,
            'customer_name' => $customer_name,
            'customer_contact_number' => $customer_contact_number,
            'customer_address' => $customer_delivery_adress,
            'customer_delivery_adress' => $customer_delivery_adress,
            'delivery_tracking_number' => ' ',
            'delivery_fee_amount' => $request->delivery_fee,
            'other_instruction' => $request->instruction,
            'delivery_courier' => ' ',
            'delivery_type' => $request->shipping_type,
            'gross_amount' => $totalPrice ,
            'tax_amount' => 0,
            'net_amount' => $totalPrice,
            'discount_amount' => 0,
            'payment_status' => 'UNPAID',
            'delivery_status' => 'Waiting for Payment',
            'status' => 'active',
        ]);
     
        $grand_gross = 0;
        $grand_tax = 0;

        $coupon_code = 0;
        $coupon_amount = 0;
        $totalQty = 0;
        $carts = Cart::where('user_id',Auth::id())->get();
        foreach ($carts as $cart) {
            
            $totalQty += $cart->qty;

            $product = $cart->product;
            $gross_amount = ($product->price * $cart->qty) + ($cart->paella_price * $cart->qty);
            $tax_amount = $gross_amount - ($gross_amount/1.12);
            $grand_gross += $gross_amount;
            $grand_tax += $tax_amount;


            $data['price'] = $product->price;
            $data['tax'] = $data['price'] - ($data['price']/1.12);
            $data['other_cost'] = 0;
            $data['net_price'] = $data['price'] - ($data['tax'] + $data['other_cost']);

            SalesDetail::create([
                'sales_header_id' => $salesHeader->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_category' => $product->category_id,
                'price' => $product->price,              
                'tax_amount' => $tax_amount,
                'promo_id' => 0,
                'promo_description' => '',
                'discount_amount' => 0,
                'gross_amount' => $gross_amount,
                'net_amount' => $gross_amount,
                'qty' => $cart->qty,             
                'uom' => $product->uom,               
                'created_by' => Auth::id()
            ]);
          
        }

        Mail::to(Auth::user())->send(new SalesCompleted($salesHeader));  
      
        $urls = [
            'notification' => route('cart.payment-notification'),
            'result' => route('profile.sales'),
            'cancel' => route('profile.sales'),
        ];
        
        $base64Code = PaynamicsHelper::payNow($requestId, Auth::user(), $carts, $totalPrice, $urls, false ,$request->delivery_fee);

        Cart::where('user_id', Auth::id())->delete();


        $this->get_coupons($totalPrice,$totalQty,$carts);
        $this->remove_cart_coupon();

        if($request->coupon_counter > 0){
            $this->update_coupon_status($request);    
        }
        
        return view('theme.paynamics.sender', compact('base64Code'));
       
    }

    public function receive_data_from_payment_gateway(Request $request)
    {

        logger($request);
        
        $paymentResponse = (isset($_POST['paymentresponse'])) ? $_POST['paymentresponse'] : null;

        if (empty($paymentResponse)) {
            return false;
        }


        
        $body = str_replace(" ", "+", $paymentResponse);

        try {
            $Decodebody = base64_decode($body);
            $ServiceResponseWPF = simplexml_load_string($Decodebody, 'SimpleXMLElement'); // new \SimpleXMLElement($Decodebody);
            $application = $ServiceResponseWPF->application;
            $responseStatus = $ServiceResponseWPF->responseStatus;

            $log = [
                'result_return' => $paymentResponse,
                'request_id' => $application->request_id,
                'response_id' => $application->response_id,
                'response_code' => $responseStatus->response_code,
                'response_message' => $responseStatus->response_message,
                'response_advise' => $responseStatus->response_advise,
                'timestamp' => $application->timestamp,
                'ptype' => $application->ptype,
                'rebill_id' => $application->rebill_id,
                'token_id' => (isset($application->token_id)) ? $application->token_id : '',
                'token_info' => (isset($application->token_info)) ? $application->token_info : '',
                'processor_response_id' => $responseStatus->processor_response_id,
                'processor_response_authcode' => $responseStatus->processor_response_authcode,
                'signature'  => $application->signature,
            ];
            $merchant = Setting::paynamics_merchant();
            $cert = $merchant['key']; //merchantkey

            $forSign = $application->merchantid . $application->request_id . $application->response_id . $responseStatus->response_code . $responseStatus->response_message . $responseStatus->
                response_advise . $application->timestamp . $application->rebill_id . $cert;

            $_sign = hash("sha512", $forSign);
           
            if ($_sign == $ServiceResponseWPF->application->signature) {

                $sales = SalesHeader::where('order_number', $application->request_id)->first();

                if (empty($sales)) {
                    $log['response_title'] = 'Sales Header not found';
                    PaynamicsLog::create($log);

                    return false;
                }

                if ($responseStatus->response_code == "GR001" || $responseStatus->response_code == "GR002") {
                    //SUCCESS TRANSACTION

                    $log['response_title'] = 'Success';
                    PaynamicsLog::create($log);

                    $sales->update([
                        'payment_status' => 'PAID',
                        'delivery_status' => 'Scheduled for Processing'
                    ]);
                    $update_payment = SalesPayment::create([
                        'sales_header_id' => $sales->id,
                        'amount' => $sales->net_amount,
                        'payment_type' => 'Paynamics-'.$application->ptype,
                        'status' => 'PAID',
                        'payment_date' => date('Y-m-d',strtotime($application->timestamp)),
                        'receipt_number' => $application->response_id,
                        'created_by' => Auth::id() ?? '1',
                        'response_body'=> $body,
                        'response_id' => $application->response_id,
                        'response_code' => $responseStatus->response_code
                    ]);

                    // $this->get_coupons();
                    
                } else if ($responseStatus->response_code == "GR053") {
                    $log['response_title'] = 'Cancelled';
                    PaynamicsLog::create($log);

                    $sales->update([
                        'payment_status' => 'CANCELLED'                        
                    ]);
                } else {

                    $log['response_title'] = 'Failed';
                    PaynamicsLog::create($log);

                    $sales->update([
                        'payment_status' => 'FAILED'
                    ]);
                }
            } else {
                $log['response_title'] = 'Invalid Signature';
                PaynamicsLog::create($log);
            }
        } catch(Exception $ex) {
            PaynamicsLog::create([
                'result_return' => $ex->getMessage(),
                'response_title' => 'Try catch Error'
            ]);
        }
    }

    public function generate_payment(Request $request){
        $salesHeader = SalesHeader::where('order_number',$request->order)->first();        
        $sign = $this->generateSignature('2amqVf04H9','PH00125',$request->order,str_replace(".", "", number_format($request->amount,2,'.','')),'PHP');
        $payment = $this->ipay($salesHeader,$request->amount,$sign);
        return response()->json([
                'success' => true,
                'order_number' => $request->order,
                'customer_contact_number' => Auth::user()->contact_mobile, 
                'amount' => number_format($request->amount,2,'.',''),
                'signature' => $sign
            ]);
    }  

    public function get_coupons($totalPrice,$totalQty,$cartProducts)
    {
        // // Time Setting : Date and Time only 
        //     // get all active coupons that is not yet expired.
        //     $coupons = Coupon::where('end_date','>=',today()->format('Y-m-d'))->where('end_time','>=',Carbon::now()->format('H:i'))->where('status','ACTIVE')->where('availability',0)->get();

        //     foreach($coupons as $coupon){
        //         $this->check_coupon_rule($coupon->id);
        //     }
        // //

        // Purchase Setting : Product Only
            $cart_products =  [];
            // get all customer products in the cart
            foreach($cartProducts as $cart){
                // push the product id in the array 
                array_push($cart_products,$cart->product_id); 
            }

            // get all active coupons with purchase product rule
            $counter = 1;
            $couponProducts = Coupon::whereNotNull('purchase_product_id')->where('status','ACTIVE')->get();
            foreach($couponProducts as $coupon){
                $products = explode('|',$coupon->purchase_product_id);
                foreach($products as $productid){
                    // check if this product id exist in the array
                    if(in_array($productid,$cart_products)){
                        if($counter == 1){
                            $this->check_coupon_rule($coupon->id);
                        }
                        $counter++;
                    }
                }
            }
        //

        // Purchase Setting : Total Amount Only
            $couponTotalAmount = Coupon::whereNotNull('purchase_amount')->where('status','ACTIVE')->where('availability',0)->get();

            foreach($couponTotalAmount as $coupon){
                if($coupon->purchase_amount_type == 'min'){
                    if($totalPrice >= $coupon->purchase_amount){
                        $this->check_coupon_rule($coupon->id);
                    }
                }

                if($coupon->purchase_amount_type == 'max'){
                    if($totalPrice <= $coupon->purchase_amount){
                        $this->check_coupon_rule($coupon->id);
                    }
                }

                if($coupon->purchase_amount_type == 'exact'){
                    if($totalPrice == $coupon->purchase_amount){
                        $this->check_coupon_rule($coupon->id);
                    }
                }
            }
        //

        // Purchase Setting : Total Quantity Only
            $couponTotalQty = Coupon::whereNotNull('purchase_qty')->where('status','ACTIVE')->get();

            foreach($couponTotalQty as $coupon){
                if($coupon->purchase_qty_type == 'min'){
                    if($totalQty >= $coupon->purchase_qty){
                        $this->check_coupon_rule($coupon->id);
                    }
                }

                if($coupon->purchase_qty_type == 'max'){
                    if($totalQty <= $coupon->purchase_qty){
                        $this->check_coupon_rule($coupon->id);
                    }
                }

                if($coupon->purchase_qty_type == 'exact'){
                    if($totalQty == $coupon->purchase_qty){
                        $this->check_coupon_rule($coupon->id);
                    }
                }
            }
        //

    }

    public function check_coupon_rule($couponID)
    {
        // get total number of customers having this couponID
        $totalCustomer = CustomerCoupon::where('coupon_id',$couponID)->count();

        $coupon = Coupon::find($couponID);
        // if coupon has set customer limit
        if(isset($coupon->customer_limit)){
            // check if customer limit is not reach
            if($totalCustomer <= $coupon->customer_limit){
                // check if customer already get the coupon
                $couponExist = CustomerCoupon::where('coupon_id',$couponID)->where('customer_id',Auth::id())->exists();
                // if not exist, grant the coupon
                if(!$couponExist){
                    $this->grant_coupon($coupon->id);  
                }
            }
        } else {
            $this->grant_coupon($coupon->id);
        }
    }

    public function grant_coupon($couponID){
        CustomerCoupon::create([
            'coupon_id' => $couponID,
            'customer_id' => Auth::id()
        ]); 
    }

    public function remove_cart_coupon()
    {
        CouponCart::where('customer_id',Auth::id())->delete();
    }

    public function update_coupon_status($request)
    {
        $data = $request->all();
        $coupons = $data['couponid'];

        foreach($coupons as $key => $c){
            $customerCoupon = CustomerCoupon::where('customer_id',Auth::id())->where('coupon_id',$c);


            // if coupon not exist in customers coupon
            if($customerCoupon->count() == 0){
                CustomerCoupon::create([
                    'coupon_id' => $c,
                    'usage_status' => 1,
                    'coupon_status' => 'INACTIVE',
                    'customer_id' => Auth::id()
                ]);
            } else {
                $coupon = Coupon::find($c);

                if(isset($coupon->usage_limit)){
                    if($coupon->usage_limit == 'single_use'){
                        $customerCoupon->update(['usage_status' => 1, 'coupon_status' => 'INACTIVE']);
                    }

                    if($coupon->usage_limit == 'multiple_use'){
                        $couponUsage = CouponSale::where('customer_id',Auth::id())->where('coupon_id',$c)->count();
                        if($couponUsage == $coupon->usage_limit_no){
                            $customerCoupon->update(['usage_status' => 1, 'coupon_status' => 'INACTIVE']);
                        }
                    }
                }

            }
        }
    }
}
