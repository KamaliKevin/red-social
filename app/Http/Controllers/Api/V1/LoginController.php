<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])
            && Auth::user()->hasVerifiedEmail()) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;
            return response()->json([
                'message' => 'User logged in successfully.',
                'token' => $token
            ], 200);
        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
    }
}
