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
    $context = 'iloveaustin';

    // == monthly == //
    $router->post("$context/monthly/list", 'MonthlyController@listMonthlies');

    // == period == //
    $router->get("$context/period/get/{month}/{year}", 'PeriodController@getPeriods');
    $router->get("$context/period/get", 'PeriodController@getPeriods');

    // == snapshot == //
    $router->post("$context/snapshot/list", 'SnapshotController@listSnapshots');
    $router->post("$context/snapshot/delete", 'SnapshotController@deleteSnapshot');
    $router->post("$context/snapshot/save", 'SnapshotController@saveSnapshot');

    // == login == //
    $router->post("$context/login", 'LoginController@login');
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

