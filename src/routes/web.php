<?php

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

$router->get('/', function () {
  return "Hello stranger from the api developer";
});

$router->post('/auth', '\App\Http\Controllers\AuthController');

$router->group(
  [
    'prefix' => 'api', 
    'middleware' => [
      'jwt_auth',
      'enforce_json'
    ]
  ], 
  function() use ($router){
    $router->get('jobs', '\App\Http\Controllers\JobController@index');
    $router->get('jobs/{id}', '\App\Http\Controllers\JobController@show');
    $router->post('jobs', '\App\Http\Controllers\JobController@store');
    $router->put('jobs/{id}', '\App\Http\Controllers\JobController@update');
    $router->delete('jobs/{id}', '\App\Http\Controllers\JobController@destroy');
  }
);
