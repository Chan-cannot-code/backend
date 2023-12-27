<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ( request()->routeIs('user.login')){
            return [
                'school_id'      => 'required|string|max:25',
                'password'   => 'required|string|min:8',
            ];
            }

        else if ( request()->routeIs('user.register')){
            return [
                'fullname'       => 'nullable|string|max:255',
                'custom_email'      => 'nullable|string|email|max:255|unique:App\Models\LoginCredential,custom_email|',
                'school_id'   => 'required|string|min:8|confirmed|unique:login_credentials,school_id',           
                'password'   => 'required|string|min:8|confirmed',
            ];
            }
        
        else if ( request()->routeIs('user.addProduct')){
            return [
                'pname'       => 'nullable|string|max:255',
                'description'      => 'nullable|string|max:255',
                'price'   => 'required|string|min:8', 
                'image'       =>  'required|image|mimes:jpg,bmp,png|max:2048'          
            ];
            }   
    }
}