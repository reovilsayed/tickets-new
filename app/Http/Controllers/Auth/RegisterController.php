<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Verification;
use App\Rules\PortuguesePhoneNumber;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{

    use RegistersUsers;

    public function redirectTo()
    {

        switch (auth()->user()->role_id) {
            case 1:
                return RouteServiceProvider::ADMIN;
                break;
            case 2:
                return RouteServiceProvider::USER;
                break;


            default:
                return RouteServiceProvider::HOME;
                break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_number' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // $number = $data['country_code']."". $data['contact_number'];
        $array = [
            'name' => $data['name'],
            'l_name' => $data['l_name'],
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            'country' => $data['country'],
            'password' => Hash::make($data['password']),
            'role_id' => 2,
            'uniqid' => uniqid()
        ];
        $user = User::create($array);
        $verify_token = Str::random(20);


        return $user;
    }
    public function vendorCreate()
    {
        return view('auth.seller.register');
    }
}
