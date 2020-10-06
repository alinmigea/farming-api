<?php

use App\Provider\ConfigProvider;
use App\Provider\DatabaseProvider;
use App\Provider\ModelProvider;
use App\Provider\ServiceProvider;
use App\Provider\ValidationProvider;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;

// the Dependency Injector
$di = new FactoryDefault();
Di::setDefault($di);

$configProvider = new ConfigProvider();
$configProvider->register($di);

$databaseProvider = new DatabaseProvider();
$databaseProvider->register($di);

$modelProvider = new ModelProvider();
$modelProvider->register($di);

$serviceProvider = new ServiceProvider();
$serviceProvider->register($di);

$validationProvider = new ValidationProvider();
$validationProvider->register($di);
