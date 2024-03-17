<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login()
    {
        $data['user']  = User::where('email', 'test@gmail.com')
        ->firstOrFail();
        Auth::login($data['user'] );
        $data['token'] = JWTAuth::fromUser($data['user']);
        $response = [
            'status' => 'success',
            'message' => 'User is logged in successfully.',
            'data' => $data,
        ];
        return response()->json($response, 200);

    }
}
