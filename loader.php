<?php

use Dotenv\Dotenv;
use Phalcon\Loader;

// creates the autoloader
$namespaceLoader = new Loader();

// register the namespaces
$namespaceLoader->registerNamespaces(
    [
        'App' => 'app',
        'App\Controller' => 'app/controllers',
        'App\Model' => 'app/models',
        'App\Helper' => 'app/helpers',
        'App\Provider' => 'app/providers',
        'App\Service' => 'app/services',
        'App\Validation' => 'app/validations',
        'App\Exception' => 'app/exceptions',
    ]
);

// register autoloader
$namespaceLoader->register();

// create the env loader
$envLoader = Dotenv::createUnsafeImmutable(__DIR__ . './app/configs/');

// send variables to env variables
$envLoader->load();
