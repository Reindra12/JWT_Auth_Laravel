<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Driver;
use App\Models\Petugas;
use Validator;
use DB;
use Config;

use Illuminate\Contracts\Auth\UserProvider;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller 
{


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register','registerpetugas']]);
        // $this->middleware('auth:petugas', ['except' => ['login', 'register','registerpetugas']]);

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    public function login(Request $request){

    	$validator = Validator::make($request->all(), [
            'user' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        
        // $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        
        }

        // if (! $token = auth()->attempt($validator->validated())) {
        //     return response()->json(['error' => 'Unauthorized'], 401);

        
        // }
        if(auth()->guard('api2')->attempt($validator->validated())){

            config(['auth.guards.api.provider' => 'api2']);
            
            $petugas = Petugas::select('tb_petugas.*')->find(auth()->guard('api2')->user()->id_petugas);
            $success =  $petugas;
            // $success['token'] =  $petugas->createToken('MyApp',['admin'])->accessToken; 
            
            return response()->json($success, 200);
        }else if(auth()->guard('api')->attempt($validator->validated())){ 
            config(['auth.guards.api.provider' => 'api2']);
            
            $driver = Driver::select('tb_driver.*')->find(auth()->guard('api')->user()->id_driver);
            $success =  $driver;
            // $success['token'] =  $petugas->createToken('MyApp',['admin'])->accessToken; 
            
            return response()->json($success, 200);
            
        }else{
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }

        return $this->createNewToken($token);

        }

    public function login2(Request $request) {
        // Config::set('jwt.user', 'App\Driver'); 
        // Config::set('auth.providers.petugas.model', \App\petugas::class);
        // Config::set('auth.api', App\Driver::class);
       
            $credentials = $request->only('user', 'password');
    
            //valid credential
            $validator = Validator::make($credentials, [
                'user' => 'required|email',
                'password' => 'required|string|min:6|max:50'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            
            }elseif (! $token = auth()->attempt($validator->validated())) {            
            return response()->json(['error' => 'Unauthorized'], 401);
            }

            elseif(Auth::guard('api2')->attempt($credentials)){
                try {
                    if (! $token = JWTAuth::attempt($credentials)) {
                       
                        return response()->json([
                            'success' => false,
                            'message' => 'Login ssssss are invalid.',
                        ], 400);
                    }
                } catch (JWTException $e) {
                return $credentials;
                    return response()->json([
                            'success' => false,
                            'message' => 'Could not create token.',
                        ], 500);
                }
                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'user' => auth()->user()
                ]);
            }
            //Send failed response if request is not valid
            // if ($validator->fails()) {
            //     return response()->json(['error' => $validator->messages()], 200);
            // }
    
            // //Request is validated
            // //Crean token
            // try {
            //     if (! $token = JWTAuth::attempt($credentials)) {
                   
            //         return response()->json([
            //             'success' => false,
            //             'message' => 'Login credentials are invalid.',
            //         ], 400);
            //     }
            // } catch (JWTException $e) {
            // return $credentials;
            //     return response()->json([
            //             'success' => false,
            //             'message' => 'Could not create token.',
            //         ], 500);
            // }
            if(Auth::guard('api')->attempt($credentials)){
                try {
                    if (! $token = JWTAuth::attempt($credentials)) {
                       
                        return response()->json([
                            'success' => false,
                            'message' => 'Login ssssss are invalid.',
                        ], 400);
                    }
                } catch (JWTException $e) {
                return $credentials;
                    return response()->json([
                            'success' => false,
                            'message' => 'Could not create token.',
                        ], 500);
                }
                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'user' => auth()->user()
                ]);
            }
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

        $userpetugas = Petugas::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $userpetugas
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
          
        ]);
    }

}