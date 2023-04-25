<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //reques caturar valores
    public function register(Request $request){

return User::create([
    'name' => $request->input('name'),
    'email' => $request->input('email'),
    'email_verified_at' => $request->input('email_verified_at'),
    //HASH INCRIPTA CONTRASEÑA
    'password' => Hash::make($request->input('password'))
]);
    }



    public function login(Request $request)
    {
  
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $token, 60 * 24); 
        return response([
            'message' => $token
        ])->withCookie($cookie);

      
    }
    //datos basicos del user
    public function userProfile(Request $request){
        return Auth::user();

    }
    //cerrar sesion
    public function logout() {
      
$cookie = Cookie::forget('cookie_token');
return response (["message"=>"Cierre de sesion"]. Response::HTTP_OK)->withCookie($cookie);
    
$cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
}

}
