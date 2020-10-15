<?php

namespace App\Provider;

use App\Controller\ArticleController;
use App\Controller\AuthorController;
use App\Controller\CategoryController;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection;

class RouteProvider
{
    /**
     * @param Micro $app
     * @return void
     */
    public function register(Micro $app): void
    {
        // api name route
        $app->get(
            '/api/what-is',
            function () {
                echo "My Phalcon Blog API";
            }
        );

        // routes for Article
        $articleRoutes = new Collection();
        $articleRoutes
            ->setHandler(new ArticleController())
            ->setPrefix('/api/articles')
            ->get('/', 'list')
            ->get('/{id:[0-9]+}', 'view')
            ->post('', 'add')
            ->put('/{id:[0-9]+}', 'edit')
            ->delete('/{id:[0-9]+}', 'delete')
            ->get('/{id:[0-9]+}/categories', 'categories');
        $app->mount($articleRoutes);

        // routes for Author
        $authorRoutes = new Collection();
        $authorRoutes
            ->setHandler(new AuthorController())
            ->setPrefix('/api/authors')
            ->get('/', 'list')
            ->get('/{id:[0-9]+}', 'view')
            ->post('', 'add')
            ->post('/{id:[0-9]+}', 'edit')
            ->delete('/{id:[0-9]+}', 'delete');
        $app->mount($authorRoutes);

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
            ->get('/{id:[0-9]+}/articles', 'articles')
            ->put('/{id:[0-9]+}/articles/{articleId:[0-9]+}', 'addArticle')
            ->delete('/{id:[0-9]+}/articles/{articleId:[0-9]+}', 'deleteArticle');
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
