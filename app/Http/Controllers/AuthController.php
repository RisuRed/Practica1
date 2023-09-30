<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
     /*
    *
    *
    */
    public function login(LoginRequest $request){
        $data = $request->validated();
        //revisar el password
        if(!Auth::attempt($data)){
            return response([
                'errors' => ['El email o password son incorrectos']
            ], 422);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response()->json([
            'message' => 'Usuario logueado correctamente',
            'user' => Auth::user(),
            'access_token' => $accessToken
        ], 200);
    }
     /*
    *
    *
    */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Sesion cerrada correctamente'], 200);
    }
}
