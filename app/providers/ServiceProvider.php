<?php

namespace App\Provider;

use App\Helper\ResponseHelper;
use App\Service\CategoryService;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        // models services
        $di->setShared(CategoryService::class, function () {
            return new CategoryService();
        });
        $di->setShared(OwnerService::class, function () {
            return new OwnerService();
        });
        $di->setShared(AnimalService::class, function () {
            return new AnimalService();
        });

        // response service
        $di->setShared(ResponseHelper::class, function () {
            return new ResponseHelper();
        });
    }
}
