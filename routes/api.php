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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    Route::prefix('auth')->group(function () {
        Route::post('login', 'API\AuthController@login')->name('auth.login');
        Route::post('logout', 'API\AuthController@logout')->name('auth.logout');
        Route::post('refresh', 'API\AuthController@refresh')->name('auth.refresh');
        Route::post('show', 'API\AuthController@showMe')->name('auth.show');
    });
    Route::prefix('admin')->group(function () {
        Route::resource('categories', 'API\CategoriesController');
    });
});
