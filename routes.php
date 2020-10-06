<?php

use App\Provider\RouteProvider;
use Phalcon\Mvc\Micro;

$app = new Micro();

// register the routes
$routeProvider = new RouteProvider();
$routeProvider->register($app);

// handle the request
$app->handle(
    $_SERVER["REQUEST_URI"]
);
