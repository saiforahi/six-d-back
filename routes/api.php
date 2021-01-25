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
    $router->get('permissions',['middleware'=>'auth','uses'=>'AuthController@get_user_permissions']);
    $router->get('roles',['middleware'=>'auth','uses'=>'AuthController@get_user_roles']);
});

$router->group(['prefix' => 'role'],function () use ($router){
    $router->get('all',['middleware'=>'auth','uses'=>'Authorization\RoleController@get_all_roles']);
    $router->post('create',['middleware' => 'auth','uses' => 'Authorization\RoleController@store']);
    $router->put('update/{id}',['middleware' => 'auth','uses' => 'Authorization\RoleController@update']);
    $router->delete('delete/{id}',['middleware' => 'auth','uses' => 'Authorization\RoleController@destroy']);
});

$router->group(['prefix' => 'permission'],function () use ($router){
    $router->post('create',['middleware' => 'auth','uses'=>'Authorization\PermissionController@store']);
    $router->get('all_permissions',['middleware' => 'auth','uses' => 'Authorization\PermissionController@all_permissions']);
    $router->delete('delete/{id}',['middleware' => 'auth','uses' => 'Authorization\PermissionController@destroy']);
});

$router->group(['prefix' => 'user'],function () use ($router){
    $router->get('all_users',['middleware' => 'auth','uses' => 'Authorization\UserController@all_users']);
    $router->post('store',['middleware' => 'auth','uses' => 'Authorization\UserController@store']);
    $router->delete('delete/{id}',['middleware' => 'auth','uses' => 'Authorization\UserController@destroy']);
});

$router->group(['prefix' => 'company'], function () use ($router) {
    $router->post('create_admin', ['middleware'=>'auth','uses'=>'CompanyController@create_admin']);
    $router->get('admin/{company_id}',['middleware'=>'auth','uses'=>'CompanyController@get_admin']);
    $router->get('all',['middleware'=>'auth','uses'=>'CompanyController@get_all_companies']);
    $router->post('create',['middleware'=>['role:super-admin','auth'],'uses'=>'CompanyController@create_company']);
    $router->delete('delete/{company_id}',['middleware'=>'auth','uses'=>'CompanyController@delete_company']);
    $router->put('update/{company_id}',['middleware'=>'auth','uses'=>'CompanyController@update_company']);
});

$router->group(['prefix' => 'category'], function () use ($router) {
    $router->post('create', ['middleware'=>'auth','uses'=>'Accounts\CategoryController@create']);
    $router->get('services',['middleware'=>'auth','uses'=>'Accounts\CategoryController@get_all_services']);
    $router->put('update/{id}',['middleware'=>'auth','uses'=>'Accounts\CategoryController@update']);
    $router->get('all/{company_id}',['middleware'=>'auth','uses'=>'Accounts\CategoryController@get_all_categories_of_a_company']);
});

$router->group(['prefix' => 'service'], function () use ($router) {
    $router->post('create', ['middleware'=>'auth','uses'=>'Accounts\CategoryController@create']);
    $router->get('services',['middleware'=>'auth','uses'=>'Accounts\CategoryController@get_all_services']);
    $router->put('update/{id}',['middleware'=>'auth','uses'=>'Accounts\CategoryController@update']);
    $router->get('all/{company_id}',['middleware'=>'auth','uses'=>'Accounts\CategoryController@get_all_categories_of_a_company']);
});


