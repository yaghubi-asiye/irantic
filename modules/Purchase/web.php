<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->post('/', [
    'middleware' => 'auth',
    'uses' => 'PurchaseController@index'
]);
