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

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/test', function (Request $request) {

    $response = Http::post('http://localhost:8001/register', [
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'username' => $request->username,
        'email' => $request->email,
        'password' => $request->password,
    ]);
    return $response->json();
});
