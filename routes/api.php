<?php

use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});



// Brand CRUD
Route::controller(BrandsController::class)->group(function(){

    Route::get('index','index');
    Route::get('show/{id}','show');
    Route::post('store','store');
    Route::put('update_brand/{id}','update_brand');
    Route::delete('delete_brand/{id}','delete_brand');

});


// Category CRUD
Route::controller(CategoriesController::class)->group(function(){

    Route::get('index','index');
    Route::get('show/{id}','show');
    Route::post('store','store');
    Route::put('update_category/{id}','update_category');
    Route::delete('delete_category/{id}','delete_category');

});

