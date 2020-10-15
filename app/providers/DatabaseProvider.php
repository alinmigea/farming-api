<?php

namespace App\Provider;

use Phalcon\Db\Adapter\PdoFactory;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class DatabaseProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared('db', function () use ($di) {
            return (new PdoFactory())->load($di->getShared('config')->path('database'));
        });
    }
}
