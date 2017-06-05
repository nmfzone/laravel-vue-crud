<?php

use Illuminate\Http\Request;

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

Route::group(['namespace' => 'Api\Auth'], function () {
    Route::post('/login', 'LoginController@login');
    Route::middleware('auth:api')->post('/logout', 'LoginController@logout');
    Route::post('/register', 'RegisterController@register');
});

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Users
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UsersController@all');
        Route::get('/{user}', 'UsersController@get');
        Route::post('/', 'UsersController@store');
        Route::put('/{user}', 'UsersController@update');
        Route::delete('/{user}', 'UsersController@destroy');
    });
});
