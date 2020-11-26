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

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/login', [
    'as' => 'login', 'uses' => 'AuthController@login'
]);

$router->group(['prefix' => 'user',  'middleware' => 'auth',], function () use ($router) {

    $router->post('register', [
        'uses' => 'UserController@store'
    ]);

    $router->post('update', [
        'uses' => 'UserController@update'
    ]);

    $router->post('show', [
        'uses' => 'UserController@show'
    ]);

    $router->post('desactivate', [
        'uses' => 'UserController@delete'
    ]);

    $router->post('sendMessage', [
        'uses' => 'MessageController@store'
    ]);

    $router->post('indexmessage', [
        'uses' => 'MessageController@index'
    ]);

    $router->post('showmessage/{id}', [
        'uses' => 'MessageController@show'
    ]);

    $router->post('updatemessage/{id}', [
        'uses' => 'MessageController@update'
    ]);

    $router->post('deletemessage/{id}', [
        'uses' => 'MessageController@destroy'
    ]);
});
