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

class LoginController extends Controller
{
    public function register(Request $data)
    {
        // Validation rules
        $rules = [
            'fullname' => 'required|string|max:255',
            'custom_email' => 'required|string|email|max:255|unique:users',
            'school_id' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];
    
        // Custom messages for validation
        $messages = [
            'fullname.required' => 'Please enter your full name.',
            'custom_email.required' => 'Please enter your email address.',
            'custom_email.unique' => 'This email address is already registered.',
            'school_id.required' => 'Please enter your school ID.',
            'school_id.unique' => 'This school ID is already registered.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'Your password must be at least 8 characters long.',
        ];
    
        // Validate the data
        $validator = Validator::make($data->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        try {
            $user = LoginCredential::create([
                'fullname' => $data['fullname'],
                'custom_email' => $data['custom_email'],
                'school_id' => $data['school_id'],
                'password' => Hash::make($data['password']),
            ]);
    
            return response()->json(['user' => $user, 'message' => 'Registration successful'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Registration failed'], 500);
        }
    }
    
    public function login(RegisterRequest $request)
    {
        $user = LoginCredential::where('school_id', $request->school_id)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $response = [
            'user' => $user,
            'token' => $user->createToken($request->school_id)->plainTextToken
        ];
     
        return $response;
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
            $response = [
                'message' => 'logout'
            ];
        } else {
            $response = [
                'message' => 'User not authenticated',
            ];
        }
    
        return response()->json($response);
    }
    
}
