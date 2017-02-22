<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Ramsey\Uuid\Uuid;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return \App\Models\User::create([
            \App\Models\User::Name => $data['name'],
            \App\Models\User::Email => $data['email'],
            \App\Models\User::UUID => (string) Uuid::uuid4(),
            \App\Models\User::ApiToken => \Illuminate\Support\Str::random(90),
            \App\Models\User::Password => Hash::make($data['password']),
            \App\Models\User::Address => $data['address'],
            \App\Models\User::Phone => $data['phone'],
            \App\Models\User::RoleType => \App\Models\User::ROLE_CUSTOMER,
            \App\Models\User::AvatarUrl => $data['avatar_url'],
            \App\Models\User::IsEnabled => 1,
            \App\Models\User::LastLoginAt => date("Y-m-d H:i:s"),
            \App\Models\User::LastActivityAt => date("Y-m-d H:i:s"),
            \App\Models\User::LastSeenIP => \Request::ip()
        ]);
    }
}
