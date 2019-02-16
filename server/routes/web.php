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

$router->group(['namespace' => 'ILoveAustin'], function ($router) {

    // == snapshot == //
    $router->post('iloveaustin/snapshot/list', 'SnapshotController@listSnapshots');
    $router->post('iloveaustin/snapshot/delete', 'SnapshotController@deleteSnapshot');
    $router->post('iloveaustin/snapshot/save', 'SnapshotController@saveSnapshot');

    // == login == //
    $router->post('iloveaustin/login', 'LoginController@login');
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

