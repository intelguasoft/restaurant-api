<?php

namespace IntelGUA\FoodPoint\Http\Controllers\API;

use Illuminate\Http\Request;
use IntelGUA\FoodPoint\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }

    /**
    * Get a JWT via given credentials.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $validator = Validator::make($credentials, [ 'email' => 'required|email', 'password' => 'required']);

        if($validator->fails()){
            return response()->json([
                'data' => [
                    'ok' => false,
                    'message' => 'Wrong validation',
                    'error' => $validator->errors(),
                    'code' => 422
                    ]
                ], 422);
        }

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'data' => [
                'ok' => false,
                'message' => 'Unauthorized',
                'code' => 401
                ]
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showMe()
    {
        return response()->json(auth()->user());
    }

    public function payload()
    {
        return response()->json(auth()->payload());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json([
            'data' => [
                'ok' => true,
                'message' => 'Successfully logged out',
                'code' => 200
            ]
        ], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'data' => [
                'ok' => true,
                'message' => 'Successfully logged',
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => auth()->user(),
                'code' => 200
            ]
        ], 200);
    }
}
