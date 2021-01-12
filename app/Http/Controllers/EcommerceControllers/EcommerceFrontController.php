<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\Helpers\Webfocus\Setting;
use App\Mail\UpdatePasswordMail;
use App\Page;
use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EcommerceFrontController extends Controller
{
    public function profile(Request $request)
    {
        $footer = Page::where('slug', 'footer')->where('name', 'footer')->first();

        return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.ecommerce.profile', compact('footer','page', 'breadcrumb'));
    }

    public function update_name(Request $request)
    {
        Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
        ])->validate();

        auth()->user()->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'name' => "{$request->firstname} {$request->lastname}",
        ]);

        auth()->user()->profile->update(['name' => "{$request->firstname} {$request->lastname}"]);

        return redirect()->back()->with('success','Successfully updated name');
    }

    public function update_contact(Request $request)
    {
        Validator::make($request->all(), [
            'mobile' => 'required',
            'phone' => 'required',
        ])->validate();

        auth()->user()->profile->update($request->all());

        return redirect()->back()->with('success','Successfully updated contact information');
    }

    public function ajax_update_address(Request $request)
    {
        $address = $request->validate([
            'address_street' => 'required',
            'address_barangay' => 'required',
            'address_city' => 'required',
            'address_province' => 'required',
            'address_country' => 'required',
            'address_zip' => 'required',
        ]);

        auth()->user()->profile->update($address);

        return response()->json(['success' => true, 'message' => 'Address has bean updated.', 'address' => auth()->user()->profile->complete_address()]);
    }

    public function ajax_update_delivery_address(Request $request)
    {
        $deliveryAddress = $request->validate([
            'address_delivery_street' => 'required',
            'address_delivery_barangay' => 'required',
            'address_delivery_city' => 'required',
            'address_delivery_province' => 'required',
            'address_delivery_zip' => 'required',
            'address_delivery_country' => 'required',
        ]);

        auth()->user()->profile->update($deliveryAddress);

        return response()->json(['success' => true, 'message' => 'Delivery Address has bean updated.', 'delivery_address' => auth()->user()->profile->complete_delivery_address()]);
    }

    public function update_email(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email|max:191|unique:users,email,'.auth()->id(),
        ])->validate();

        $is_updated = auth()->user()->update([
            'email'   => $request->email
        ]);

        if($is_updated){
            auth()->logout();
            return redirect('login')->with('success', 'Email successfully changed. To login again, please use your new password!');
        } else {
            return back()->with('error', __('standard.settings.account.update_email_failed'));
        }
    }

    public function update_password(Request $request)
    {
        Validator::make($request->all(), [
            'old_password' => ['required', function ($attribute, $value, $fail) {
                if (!\Hash::check($value, auth()->user()->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ]
        ])->validate();

        $user = auth()->user();

        $is_updated = $user->update(['password' => \Hash::make($request->password, array('rounds'=>12))]);

        if ($is_updated) {
            auth()->logout();
            \Mail::to($user->email)->send(new UpdatePasswordMail(Setting::info(), $user));
            return redirect('login')->with('success', 'Password successfully changed. To login again, please use your new password!');
        } else {
            return back()->with('error', __('standard.settings.account.update_password_failed'));
        }
    }

    public function forgot_password(Request $request)
    {
        $page = new Page();
        $page->name = 'Forgot Password';

        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.customer.forgot-password', compact('page'));
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(
            ['email' => ['required', 'email', Rule::exists('users', 'email')
                ->where(function ($query) {
                        $query->whereIn('role_id', ['6']);
                    })
                ]
            ]
        );

        $user = User::where('email', $request->email)->first();

        $user->send_reset_password_email();

        if (Mail::failures()) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans('passwords.user')]);
        }

        return back()->with('status', trans('passwords.sent'));
    }


    use ResetsPasswords;

    public function showResetForm(Request $request, $token = null)
    {
        $credentials =  $request->only('email');

        if (is_null($user = $this->broker()->getUser($credentials))) {
            return abort(401);
        }

        if (!$this->broker()->tokenExists($user, $token)) {
            return redirect()->route('ecommerce.forgot_password')->with('error','Your link is expired. Please reset your password again.');
        }

        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.customer.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $credentials = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            "password" => [
                'required',
                'confirmed',
                'min:10',
                'max:150',
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ]);

        if (is_null($user = $this->broker()->getUser($request->only('email')))) {
            return abort(401);
        }

        if (!$this->broker()->tokenExists($user, $credentials['token'])) {
            return redirect()->route('ecommerce.forgot_password')->with('error','Your link is expired. Please reset your password again.');
        }

        $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return redirect()->route('home');
    }
}
