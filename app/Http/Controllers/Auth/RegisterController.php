<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Faker\Provider\ka_GE\DateTime;
use Illuminate\Support\Carbon;

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
    protected $redirectTo = '/';

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
            'fname' => ['required', 'string', 'min:3','max:255'],
            'lname' => ['required', 'string', 'min:3','max:255'],
            'remail' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'rpassword' => ['required', 'string', 'min:6', 'confirmed'],
            'birth_date'  => [
                'required',
                'date',
                'before_or_equal:' . Carbon::now()->subYear(13)->format('Y-m-d'),
                'after_or_equal:' . Carbon::now()->addYear(100)->format('Y-m-d'),
            ]
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first' => $data['fname'],
            'last' => $data['lname'],
            'email' => $data['remail'],
            'birth_date' => $data['birth_date'],
            'password' => Hash::make($data['rpassword']),
        ]);

        $user->roles()->attach(1);
        return $user;
    }
}
