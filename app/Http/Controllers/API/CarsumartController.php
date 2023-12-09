<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegisterUsers;

class CarsumartController extends Controller
{
    // use RegistersUsers;

    // protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'custom_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'custom_email' => $data['custom_email'],
            'password' => Hash::make($data['password']),
        ]);

        return $this->validate(request(), [
            'name' => 'required|string|max:255',
            'custom_email' => 'required|string|email|max:255|unique:App\Models\User,custom_email',
            'password' => 'required|min:8|confirmed',
        ]);
    }

    
}