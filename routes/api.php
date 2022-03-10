<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace'=>'User', 'prefix'=>'users'], function() {
    Route::get('/login', 'LoginController');

    Route::group(['namespace'=>'Admin', 'prefix'=>'admin'], function() {
        Route::get('/','CreateAdminController');
    });
});

Route::group(['namespace' => 'Title', 'prefix' => 'titles'], function () {
    Route::get('/', 'IndexController');
    Route::post('/', 'StoreController');
    Route::patch('/{title}', 'UpdateController');
    Route::delete('/{title}', 'DestroyController');
});

Route::group(['namespace' => 'Client', 'prefix' => 'clients'], function () {
    Route::get('/', 'IndexController');
    Route::post('/', 'StoreController');
    Route::patch('/{client}', 'UpdateController');
    Route::delete('/{client}', 'DestroyController');
});

Route::group(['namespace' => 'Image', 'prefix' => 'images'], function () {
    Route::get('/', 'IndexController');
    Route::post('/', 'StoreController');
//    Route::patch('/{image}', 'UpdateController');
//    Route::delete('/{image}', 'DestroyController');
});
