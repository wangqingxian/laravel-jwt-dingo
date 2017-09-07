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

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['namespace' => 'App\Api\Controller\V1'], function ($api) {
    $api->group(['middleware' => ['api.auth','api.throttle'],'limit' => 50,'expires' => 1],function($api){
        $api->get('home', 'HomeController@index');
        $api->get('save', 'HomeController@save');
    });

    // 授权组
    $api->group(['prefix' => 'auth'], function ($api) {
        $api->get('register', 'AuthenticateController@register')->name('auth.register');
        $api->get('authenticate', 'AuthenticateController@authenticate')->name('auth.authenticate');
        $api->get('logout', 'AuthenticateController@logout')->name('auth.logout');
        $api->get('refresh', 'AuthenticateController@refresh')->name('auth.refresh');
    });
});

$api->version('v2', ['namespace' => 'App\Api\Controller\V2'], function ($api) {
    $api->group(['middleware' => 'api.auth'],function($api){
        $api->get('home', 'HomeController@index');
        $api->get('save', 'HomeController@save');
    });

    // 授权组
    $api->group(['prefix' => 'auth'], function ($api) {
        $api->get('register', 'AuthenticateController@register')->name('auth.register');
        $api->get('authenticate', 'AuthenticateController@authenticate')->name('auth.authenticate');
        $api->get('logout', 'AuthenticateController@logout')->name('auth.logout');
        $api->get('refresh', 'AuthenticateController@refresh')->name('auth.refresh');
    });
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
