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
$router->group(['prefix' => 'company'], function () use ($router) {
    $router->post('create_admin', ['middleware'=>'auth','uses'=>'CompanyController@create_admin']);
    $router->get('get_admin',['middleware'=>'auth','uses'=>'CompanyController@get_admin']);
});

$router->post('/inventory/types','TypeController@store');
$router->get('/inventory/types', 'TypeController@index');
$router->get('/inventory/types/{id}', 'TypeController@show');
$router->post('/inventory/types/delete/{id}', 'TypeController@destroy');
$router->get('/inventory/types/edit/{id}', 'TypeController@edit');
$router->post('/inventory/types/update/{id}', 'TypeController@update');

$router->post('/inventory/category', 'CategoryController@store');


