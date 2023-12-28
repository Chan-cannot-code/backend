<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // Add this line for Validator
use Illuminate\Validation\ValidationException;
use App\Http\Requests\RegisterRequest;
use App\Models\LoginCredential;
use Tymon\JWTAuth\Facades\JWTAuth; // Assuming you're using JWT for authentication
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function register(Request $data)
    {
        // Validation rules
        $rules = [
            'fullname' => 'required|string|max:255',
            'custom_email' => 'required|string|email|max:255|unique:login_credentials,custom_email',
            'school_id' => 'required|string|max:255|unique:login_credentials,school_id',
            'password' => 'required|string|min:8',
        ];

        // Custom messages for validation
        $user = [
            'fullname.required' => 'Please enter your full name.',
            'custom_email.required' => 'Please enter your email address.',
            'custom_email.email' => 'Please enter a valid email address.',
            'custom_email.unique' => 'This email address is already registered.',
            'school_id.required' => 'Please enter your school ID.',
            'school_id.unique' => 'This school ID is already registered.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'Your password must be at least 8 characters long.',
        ];

        // Validate the data
        $validator = Validator::make($data->all(), $rules, $user);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                    'message' => 'Error creating account'
                ],
                400
            );
        }

        // Create the user
        $user = LoginCredential::create([
            'fullname' => $data['fullname'],
            'custom_email' => $data['custom_email'],
            'school_id' => $data['school_id'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json(
            [
                'status' => 'success',
                'user' => $user,
                'message' => 'Registration successful'
            ],
            201
        );
    }



    public function login(Request $request)
    {
        $user = LoginCredential::where('school_id', $request->school_id)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'user does not exist'
            ], 404);
        }


        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    "status" => 'error',
                    'message' => 'Login credentials are invalid',
                ],
                403
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Logged in successful',
                'user' => $user,
                'token' => $token
            ],
            200
        );
    }

    public function logout(Request $request)
    {
        $request
            ->user()
            ->currentAccessToken()
            ->delete();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Logged out successfully',
            ],
            200
        );
    }

}
