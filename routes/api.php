<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});
$router->post('/login',['middleware'=>'cors','uses'=>'AuthController@login']);
$router->post('/register','AuthController@register');
$router->post('/logout',['middleware'=>'auth','uses'=>'AuthController@logout']);
$router->group(['prefix' => 'user'], function () use ($router) {
    $router->get('details', ['middleware'=>'auth','uses'=>'AuthController@get_user_details']);
});
$router->group(['prefix' => 'company'], function () use ($router) {
    $router->post('create_admin', ['middleware'=>'auth','uses'=>'CompanyController@create_admin']);
    $router->get('get_admin',['middleware'=>'auth','uses'=>'CompanyController@get_admin']);
});


