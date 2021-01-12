<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\EcommerceModel\SalesHeader;
use App\EcommerceModel\SalesDetail;
use App\EcommerceModel\Cart;

use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class SalesFrontController extends Controller
{
    public function sales_list(){

        $sales = SalesHeader::where('user_id',Auth::id())->orderBy('id','desc')->get();

        $page = new Page();
        $page->name = 'Sales Transaction';

        return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.ecommerce.sales',compact('sales','page'));
    }

    public function cancel_order(Request $request){

        $sales = SalesHeader::where('order_number',$request->order_number)->update(['status' => 'CANCELLED', 'delivery_status' => 'CANCELLED']);


        return back()->with('success','Successfully cancelled your order');
    }

    public function reorder(Request $request){
        $orders = SalesDetail::where('sales_header_id',$request->orderid)->get();

        foreach($orders as $order){
            if($order->product->Maxpurchase > 0){
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $order->product_id,
                    'qty' => 1,
                    'price' => $order->product->price
                ]);
            }
        }

        return redirect(route('cart.front.show'))->with('success','Successfully reorder.');
    }
}
