<?php

namespace App\Http\Controllers\Api\Buyer;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\MetaBuyer;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $request = request();
        $request->validate([ 
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string',
        ]); 
        $credentials = request(['email', 'password']);

        if (! $token = $this->guard()->attempt($credentials)) {
            return response()->json(['errors' => ['email' => ['Email and password did not match.']]], 422);
        }

        return $this->respondWithToken($token);
    }
    
    /**
     * Get a JWT via given credentials. (Register)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(){
        $request = request();
        $request->validate([ 
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]); 

        $metaBuyer = MetaBuyer::create([
            'verified' => 0,
            'active' => 0,
            'user_id' => 0,
            'receive_offers' =>0,
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'email' => $request->email,
            'last_name' => $request->last_name,
            'password' => bcrypt($request->password),
            'role' => \App\Enumeration\Role::$BUYER,
            'buyer_meta_id' => $metaBuyer->id,
        ]);

        $metaBuyer->user_id = $user->id;
        $metaBuyer->save();

        return $this->login();

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $this->guard()->user()->only('name', 'email'),
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }
    
    public function guard(){
        return Auth::Guard('api');
    }
}