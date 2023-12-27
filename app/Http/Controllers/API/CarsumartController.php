<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;
use App\Models\LoginCredential;

class CarsumartController extends Controller
{

    public function addProduct(UserRequest $request)
    {
        $user = User::findorFail($request->user()->$id);
        if(!is_null($user->$image)){
            Storage::disk('public')->delete('file.jpg');
        }
        $user -> $image = $request->file('image')->storePublicly('images', 'public');


 
        $user->save();
        return $user;
    }

    
}