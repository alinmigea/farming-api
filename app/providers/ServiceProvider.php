<?php

namespace App\Provider;

use App\Helper\ResponseHelper;
use App\Service\ArticleService;
use App\Service\AuthorService;
use App\Service\CategoryService;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     * @return void
     */
    public function register(DiInterface $di): void
    {
        // models services
        $di->setShared(CategoryService::class, function () {
            return new CategoryService();
        });
        $di->setShared(AuthorService::class, function () {
            return new AuthorService();
        });
        $di->setShared(ArticleService::class, function () {
            return new ArticleService();
        });

        // response service
        $di->setShared(ResponseHelper::class, function () {
            return new ResponseHelper();
        });
    }
}
