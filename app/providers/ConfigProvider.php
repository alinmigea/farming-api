<?php

namespace App\Provider;

use Phalcon\Config;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class ConfigProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared('config', function () {
            $options = [
                'database' => require_once __DIR__ . './../configs/database.php',
                'upload' => require_once __DIR__ . './../configs/upload.php',
            ];

            return (new Config($options));
        });
    }
}
