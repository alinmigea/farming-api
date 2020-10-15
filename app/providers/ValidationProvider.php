<?php

namespace App\Provider;

use App\Validation\AnimalValidation;
use App\Validation\CategoryValidation;
use App\Validation\ImageValidation;
use App\Validation\OwnerValidation;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class ValidationProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $di->setShared(CategoryValidation::class, function () {
            return new CategoryValidation();
        });
        $di->setShared(OwnerValidation::class, function () {
            return new OwnerValidation();
        });
        $di->setShared(AnimalValidation::class, function () {
            return new AnimalValidation();
        });
        $di->setShared(ImageValidation::class, function () {
            return new ImageValidation();
        });
    }
}
