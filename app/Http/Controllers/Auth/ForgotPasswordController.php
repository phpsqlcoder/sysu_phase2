<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $user = User::where('email', $request->email)->first();

        $user->send_reset_password_email();

        if (Mail::failures()) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans('passwords.user')]);
        }

        return back()->with('status', trans('passwords.sent'));
    }

    public function validateEmail(Request $request)
    {
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            ['email.exists' => trans('passwords.user')]
        );
    }

}
