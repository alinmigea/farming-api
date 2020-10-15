<?php

namespace App\Provider;

use App\Validation\ArticleValidation;
use App\Validation\AuthorValidation;
use App\Validation\CategoryValidation;
use App\Validation\ImageValidation;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class ValidationProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared(CategoryValidation::class, function () {
            return new CategoryValidation();
        });
        $di->setShared(AuthorValidation::class, function () {
            return new AuthorValidation();
        });
        $di->setShared(ArticleValidation::class, function () {
            return new ArticleValidation();
        });
        $di->setShared(ImageValidation::class, function () {
            return new ImageValidation();
        });
    }
}
