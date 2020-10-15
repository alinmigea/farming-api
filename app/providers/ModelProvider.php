<?php

namespace App\Provider;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model\MetaData\Memory;

class ModelProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared('modelsManager', Manager::class);
        $di->setShared('modelsMetadata', Memory::class);
    }
}
