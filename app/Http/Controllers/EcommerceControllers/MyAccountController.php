<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\EcommerceModel\Cart;
use App\EcommerceModel\SalesHeader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Page;

class MyAccountController extends Controller
{

    public function manage_account(Request $request)
    {
        $member = auth()->user();
        $user = auth()->user();
        $selectedTab = 0;

        if ($request->has('tab')) {
            $selectedTab = ($request->tab == 'contact-information') ? 1 : 0;
            $selectedTab = ($request->tab == 'my-address') ? 2 : $selectedTab;
        }
        $page = new Page();
        $page->name = 'Manage Account';
        return view('theme.sysu.ecommerce.my-account.manage-account', compact('member', 'user', 'selectedTab','page'));
    }

    public function update_personal_info(Request $request)
    {
      
        $personalInfo = $request->validate([
            'firstname' => 'required|max:150|regex:/^[\pL\s\-]+$/u',
            'lastname' => 'required|max:150|regex:/^[\pL\s\-]+$/u',
          
        ]);

        auth()->user()->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname
        ]);
   

        return redirect()->back()->with('success-personal', 'Personal information has been updated');
    }

    public function update_contact_info(Request $request)
    {
        $route = route('my-account.manage-account').'?tab=contact-information';

        $contactInfo = $request->only(['mobile', 'phone']);

        $validateData = Validator::make($contactInfo, [     
            "mobile" => "required|max:150",
        ]);

        if ($validateData->fails()) {
            return redirect($route)
                ->withErrors($validateData)
                ->withInput();
        }

        auth()->user()->update($contactInfo);

        return redirect($route)->with('success-contact', 'Personal information has been updated');
    }

    public function update_address_info(Request $request)
    {
        
        $route = route('my-account.manage-account').'?tab=my-address';

        $addressInfo = $request->only(['address_city', 'address_municipality','address_street', 'address_zip']);

        $attributeNames = [
            "address_city" => "City",
            "address_municipality" => "Barangay",
            "address_street" => "Street",
            "address_zip" => "Zip Code",          
        ];

        $validateData = Validator::make($addressInfo, [            
            "address_city" => "required|max:150",
            "address_municipality" => "required|max:150",
            "address_street" => "required|max:150",
            "address_zip" => "required|max:150"           
        ])->setAttributeNames($attributeNames);

        if ($validateData->fails()) {
            return redirect($route)
                ->withErrors($validateData)
                ->withInput();
        }

        auth()->user()->update($addressInfo);

        return redirect($route)->with('success-address', 'Personal information has been updated');
    }

    public function change_password()
    {
        $page = new Page();
        $page->name = 'Manage Account';
        return view('theme.sysu.ecommerce.my-account.change-password',compact('page'));
    }

    public function update_password(Request $request)
    {
        $personalInfo = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!\Hash::check($value, auth()->user()->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => [
                'required',
                'min:8',
                'max:150',               
            ],
            'confirm_password' => 'required|same:password',
        ]);

        auth()->user()->update(['password' => bcrypt($personalInfo['password'])]);

        return redirect()->back()->with('success', 'Password has been updated');
    }

    public function pay_now(Request $request, $orderNumber)
    {
        $sale = SalesHeader::where('user_id', auth()->id())->where('order_number', $orderNumber)->first();

        if (empty($sale)) {
            abort(404);
        }

        $requestId = $orderNumber;
        $member = auth()->user()->profile;
        $products = $sale->items;

        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.cart.paynamics-sender', compact('products','requestId', 'member'));

    }

    public function reorder(Request $request, $orderNumber)
    {
        $sale = SalesHeader::where('user_id', auth()->id())->where('order_number', $orderNumber)->first();

        if (empty($sale)) {
            abort(404);
        }

        foreach ($sale->items as $item) {
            Cart::create([
                'product_id' => $item->product_id,
                'user_id' => $sale->user_id,
                'qty' => $item->qty,
                'price' => $item->product->price,
                'with_installation' => $item->product->with_installation,
                'installation_fee' => $item->product->installation_fee
            ]);
        }

        $sale->delete();

        return redirect(route('cart.front.show'));
//        return redirect()->back()->with('success', 'Reorder has been successful');
    }
}
