<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;

use App\Http\Controllers\TerimaOrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// route::get('pengecekan', 'App\Http\Controllers\TerimaOrderController@index');


// return response()->json([ 'valid' => auth()->check() ]);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login2', [AuthController::class, 'login2']);
    Route::post('/loginpetugas', [PetugasController::class, 'loginpetugas']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/registerpetugas', [PetugasController::class, 'registerpetugas']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);   
    
    

    // Route::post('/login', [PetugasController::class, 'login']);
    // Route::post('/registerpetugas', [PetugasController::class, 'register']);
    // Route::post('/logout', [PetugasController::class, 'logout']);
    // Route::post('/refresh', [PetugasController::class, 'refresh']);
    // Route::get('/user-profile', [PetugasController::class, 'userProfile']);    
    // Route::get('/', 'ApiProdukController@index');
    // Route::get('/', 'ApiProdukController@index');

});

// Route::group([
//     'middleware' => 'petugas',
//     'prefix' => 'auth'
// ],
// function ($router) {
//     Route::post('/login', [PetugasController::class, 'login']);
//     Route::post('/register', [PetugasController::class, 'register']);
//     Route::post('/logout', [PetugasController::class, 'logout']);
//     Route::post('/refresh', [PetugasController::class, 'refresh']);
//     Route::get('/user-profile', [PetugasController::class, 'userProfile']);    
//     // Route::get('/', 'ApiProdukController@index');

// });

