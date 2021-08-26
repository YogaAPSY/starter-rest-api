<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controller\Api\V1\UserController;

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

// Route::resource('user', UserController::class);

Route::group(['prefix' => 'v1',  'namespace' => 'Api\V1'], function () {
    route::post('auth/login', 'AuthController@login');
    route::resource('user', 'UserController');
});

Route::group(['prefix' => 'v1',  'namespace' => 'Api\V1', 'middleware' => ['auth-user', 'auth:api']], function () {
    route::get('tes', 'AuthController@index');
    route::get('auth/logout', 'AuthController@logout');
});
