<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Driver;
use App\Models\Petugas;
use Validator;
use DB;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register','registerpetugas']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    public function login(Request $request){

    // $rules = [
    //     'user' => 'required|email',
    //     'password' => 'required|string|min:6',
    // ];
    // $messages = [
    // "user.exists" => "Lorem ipsum dolor sit amet.",
    // "password.unique" => "Lorem ipsum dolor sit amet."
    // ];

    	$validator = Validator::make($request->all(), [
            'user' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        
        // $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        if(auth()->guard('api2')->attempt($validator->validated())){

            config(['auth.guards.api.provider' => 'api2']);
            
            $petugas = Petugas::select('tb_petugas.*')->find(auth()->guard('api2')->user()->id_petugas);
            $success =  $petugas;
            // $success['token'] =  $petugas->createToken('MyApp',['admin'])->accessToken; 
            
            return response()->json($success, 200);
        }
    

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            // 'id_driver' => 'required|string|between:1,100',
            'nama_driver' => 'required|string|between:2,100',
            'user' => 'required|string|email|max:100|unique:tb_driver',
            'password' => 'required|string|confirmed|min:6',
            'no_ktp' => 'required|string|between:5,100',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = Driver::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
    public function registerpetugas(Request $request) {
        $validator = Validator::make($request->all(), [
            // 'id_driver' => 'required|string|between:1,100',
            'nama_lengkap' => 'required|string|between:2,100',
            'user' => 'required|string|email|max:100|unique:tb_petugas',
            'password' => 'required|string|confirmed|min:6',
            // 'no_ktp' => 'required|string|between:5,100',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = Petugas::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        
            'message' => 'User successfully registered',
        ]);
    }

}