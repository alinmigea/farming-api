<?php

namespace App\Provider;

use App\Controller\AnimalController;
use App\Controller\CategoryController;
use App\Controller\OwnerController;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection;

class RouteProvider
{
    public function register(Micro $app): void
    {
        // api name route
        $app->get(
            '/api/what-is',
            function () {
                echo 'Farming API';
            }
        );

        // routes for Animal
        $animalRoutes = new Collection();
        $animalRoutes
            ->setHandler(new AnimalController())
            ->setPrefix('/api/animals')
            ->get('/', 'list')
            ->get('/{id:[0-9]+}', 'view')
            ->post('', 'add')
            ->put('/{id:[0-9]+}', 'edit')
            ->delete('/{id:[0-9]+}', 'delete')
            ->get('/{id:[0-9]+}/categories', 'categories');
        $app->mount($animalRoutes);

        // routes for Owner
        $ownerRoutes = new Collection();
        $ownerRoutes
            ->setHandler(new OwnerController())
            ->setPrefix('/api/owners')
            ->get('/', 'list')
            ->get('/{id:[0-9]+}', 'view')
            ->post('', 'add')
            ->post('/{id:[0-9]+}', 'edit')
            ->delete('/{id:[0-9]+}', 'delete');
        $app->mount($ownerRoutes);

        // routes for Category
        $categoryRoutes = new Collection();
        $categoryRoutes
            ->setHandler(new CategoryController())
            ->setPrefix('/api/categories')
            ->get('/', 'list')
            ->get('/{id:[0-9]+}', 'view')
            ->post('', 'add')
            ->put('/{id:[0-9]+}', 'edit')
            ->delete('/{id:[0-9]+}', 'delete')
            ->get('/{id:[0-9]+}/animals', 'animals')
            ->put('/{id:[0-9]+}/animals/{animalId:[0-9]+}', 'addAnimal')
            ->delete('/{id:[0-9]+}/animals/{animalId:[0-9]+}', 'deleteAnimal');
        $app->mount($categoryRoutes);

        // other routes
        $app->notFound(
            function () use ($app) {
                $app->response->setStatusCode(404, 'Not Found');
                $app->response->sendHeaders();

                echo 'This is crazy, but this route was not found!';
            }
        );
    }
}
