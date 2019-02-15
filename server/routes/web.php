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

// citygen
$router->group(['namespace' => 'CityGen'], function ($router) {
    $router->get('citygenerator/lists', 'CityGenController@getLists');
    $router->post('citygenerator/generate', 'CityGenController@generate');
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

