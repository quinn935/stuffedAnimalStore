<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
            'remember' => 'boolean'
        ]);
        //$credentials = [
//     'email' => 'user@example.com',
//     'password' => 'password123',
//     'remember' => true,
// ];

        // if remember is null, set rememeber to false
        $remember = $credentials['remember']??false;
        //unset() in PHP is used to remove a variable or an array element.
        //the $credentials array will no longer have an element with the key 'remember'.
        unset($credentials['remember']);
        //Auth::attempt second parameter true/false  determines if a long-lived cookie should be set to remember the user.
        //If the $remember parameter is set to true, Laravel will issue a "remember token" that gets stored both in the database (associated with the user record) and as a cookie in the user's browser.
        if(!Auth::attempt($credentials, $remember)){
            return response([
                'message'=>'Email or password is incorrect'
            ], 422);
        }

        $user = Auth::user();
        if(!$user->is_admin){
            Auth::logout();
            return response([
                'message' => 'You are not an admin'
            ], 403);
        }

        if(!$user->email_verified_at){
            Auth::logout();
            return response([
                'message' => 'Your email address is not verified'
            ], 403);
        }

        //Sanctum is a simple package you may use to issue API tokens to your users without the complication of OAuth.
        //Upon successful authentication, the server issues client a Bearer token that should be included in the Authorization header
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }


    public function logout(){
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response('', 204);
    }

    public function getUser(Request $request){
        return new UserResource($request->user());
    }

}
