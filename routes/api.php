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
$router->post('/login','AuthController@login');
$router->post('/register','AuthController@register');
$router->post('/logout',['middleware'=>'auth','uses'=>'AuthController@logout']);
$router->group(['prefix' => 'user'], function () use ($router) {
    $router->get('details', ['middleware'=>'auth','uses'=>'AuthController@get_user_details']);
});
// $router->post('/login',)

