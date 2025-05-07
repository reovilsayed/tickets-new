<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    public function redirectTo()
    {
        switch (auth()->user()->role_id) {
            case 1:
                return RouteServiceProvider::ADMIN;
                break;
            case 2:
                return RouteServiceProvider::USER;
                break;

            // case 3:
            //     return RouteServiceProvider::VENDOR;
            //     break;
            case 8:
                return RouteServiceProvider::WALLET;
                break;
            default:
                return RouteServiceProvider::HOME;
                break;
        }
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $this->_registerOrLoginUser($user);
            return redirect()->route('user.dashboard');
        } catch (\Exception $e) {

            return redirect('/login')->withErrors('Unable to fetch user data from Google');
        }

    }
    // facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {

        try {
            $user = Socialite::driver('facebook')->user();
            $this->_registerOrLoginUser($user);
            return redirect()->route('user.dashboard');
        } catch (\Exception $e) {

            return redirect('/login')->withErrors('Unable to fetch user data from Google');
        }
    }

    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', $data->email)->first();
        if (! $user) {
            $user = User::create([
                'name'        => $data->name,
                'email'       => $data->email,
                'avatar'      => $data->avatar,
                'provider_id' => $data->id,
            ]);
        }
        Auth::login($user);
    }
}
