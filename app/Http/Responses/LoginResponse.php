<?php

namespace App\Http\Responses;

class LoginResponse
{
    public static function success($user)
    {
        return response()->json([
            'success' => true,
            'message' => 'Login Success!',
            'data'    => $user,
            'token'   => $user->createToken('authToken')->accessToken
        ]);
    }

    public static function failed()
    {
        return response()->json([
            'success' => false,
            'message' => 'Login Failed! Invalid email or password'
        ], 401);
    }
}
