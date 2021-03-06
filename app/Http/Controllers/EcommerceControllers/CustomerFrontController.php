<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\EcommerceModel\Cart;
use App\EcommerceModel\Member;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Webfocus\Setting;
use Illuminate\Validation\Rule;
use Session;
use App\Page;
use App\EcommerceModel\Product;

class CustomerFrontController extends Controller
{
    public function sign_up(Request $request) {

        $page = new Page();
        $page->name = 'Sign Up';

        return view('theme.sysu.ecommerce.customer.sign-up',compact('page'));

    }

    public function customer_sign_up(Request $request) {

        Validator::make($request->all(), [
            'email' => 'required|email|max:191|unique:users',
            'lname' => 'required',
            'fname' => 'required',
            'address_street' => 'required',
            'address_municipality' => 'required',
            'address_city' => 'required',
            'address_zip' => 'required',
            'contact_tel' => '',
            'contact_mobile' => 'required',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8'
        ])->validate();

       
        $user = User::create([
            'name' => $request->fname.' '.$request->lname,
            'password' => \Hash::make($request->password),
            'firstname' => $request->fname,
            'lastname' => $request->lname,
            'email' => $request->email,
            'address_street' => $request->address_street,
            'address_municipality' => $request->address_municipality,
            'address_city' => $request->address_city,
            'address_zip' => $request->address_zip,            
            'phone' => $request->contact_tel,
            'mobile' => $request->contact_mobile,
            'remember_token' => str_random(10),
            'email_verified_at' => date('Y-m-d H:i:s'),
            'is_active' => 1,
            'role_id' => 6
        ]);   
        

        Auth::login($user);

        return redirect(route('product.front.list'))->with('success','Registration Successful!');
    }

    public function get_random_code($length = 6)
    {
        $token = "";
        $codeAlphabet= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        $member = \App\EcommerceModel\Member::where('code', $token)->first();

        while($token == "" || $member) {
            $token = "";
            for ($i = 0; $i < $length; $i++) {
                $token .= $codeAlphabet[random_int(0, $max-1)];
            }
            $member = \App\EcommerceModel\Member::where('code', $token)->first();
        }

        return $token;
    }

    public function login(Request $request) {

        $page = new Page();
        $page->name = 'Login';

        return view('theme.sysu.ecommerce.customer.login',compact('page'));

    }

    public function customer_login(Request $request)
    {
        $userCredentials = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            unset($userCredentials['username']);
            $userCredentials['email'] = $request->email;
        }

        $cart = session('cart', []);
        
        if (Auth::attempt($userCredentials)) {
       
            if(Auth::user()->role_id <> '6'){ // block cms users from using this login form
                Auth::logout();
                return back()->with('error', 'Administrative accounts are not allowed to login as customer.'); 
            }

            if(Auth::user()->is_active <> 1){ // block inactive users from using this login form
                Auth::logout();
                return back()->with('error', 'Account is Inactive.'); 
            }


            foreach ($cart as $order) {
                $product = Product::find($order['product_id']);
                $cart = Cart::where('product_id', $order['product_id'])
                    ->where('user_id', Auth::id())
                    ->first();

                if (!empty($cart)) {
                    $newQty = $cart->qty + $order['qty'];
                    $cart->update([
                        'qty' => $newQty,
                        'price' => $product->price,
                        'paella_price' => $order['paella_price']
                    ]);
                } else {
                    Cart::create([
                        'product_id' => $order['product_id'],
                        'user_id' => Auth::id(),
                        'qty' => $order['qty'],
                        'price' => $product->price,
                        'paella_price' => $order['paella_price']
                    ]);
                }
            }

            session()->forget('cart');
            $cnt = Cart::where('user_id',Auth::id())->count();
            if($cnt > 0)
                return redirect(route('cart.front.show'));
            else
                return redirect(route('product.front.list'));
        } else {
            Auth::logout();
            return back()->with('error', __('auth.login.incorrect_input'));    
        }

    }

    public function logout()
    {
        Auth::logout();

        return redirect(route('customer-front.login'));
    }

    public function forgot_password(Request $request) {

        $page = new Page();
        $page->name = 'Forgot Password';

        return view('theme.sysu.ecommerce.customer.forgot-password');

    }

    public function customer_forgot_password(Request $request) {

        return back();

    }

    public function register_guest(Request $request) {

        $page = new Page();
        $page->name = 'Forgot Password';

        return view('theme.sysu.ecommerce.customer.register-guest');

    }
}
