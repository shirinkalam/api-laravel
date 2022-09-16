<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::resource('articles',ArticleController::class);

    Route::group(['prefix' => 'auth'], function ($router) {

        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');

    });

});
