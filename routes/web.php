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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('register', 'UserController@register');
    
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/', 'UserController@getAllUser');
        $router->get('/{id}', 'UserController@getUser');
        $router->post('/update/{id}', 'UserController@updateUser');
        $router->delete('/{id}', 'UserController@deleteUser');
    });

});