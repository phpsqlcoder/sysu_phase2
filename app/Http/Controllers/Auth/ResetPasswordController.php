<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        $credentials =  $request->only('email');

        if (is_null($user = $this->broker()->getUser($credentials))) {
            return abort(401);
        }

        if (!$this->broker()->tokenExists($user, $token)) {
            return redirect()->route('password.request')->with('error','Your link is expired. Please reset your password again.');
        }

        if ($request->has('user') && $request->user == 'new') {
            return view('auth.passwords.new-user')->with(
                ['token' => $token, 'email' => $request->email]
            );
        }

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function sendResetResponse(Request $request, $response)
    {
        if(Auth::user()->role_id == 6){
            return redirect()->route('my-account.manage-account')
                ->with('success','Password reset successfully!');
        }else{
            return redirect()->route('dashboard')
                ->with('success','Password reset successfully!');
        }

    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8',
                'confirmed',                
            ]
        ];
    }
}
