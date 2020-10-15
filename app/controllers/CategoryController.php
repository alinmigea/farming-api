<?php

namespace App\Controller;

use App\Exception\BaseException;
use App\Helper\ResponseHelper;
use App\Service\CategoryService;
use App\Validation\CategoryValidation;
use Exception;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Resultset;

class CategoryController extends Controller
{
    private CategoryService $service;

    private CategoryValidation $validation;

    private ResponseHelper $responseHelper;

    /**
     * Set the helpers on construct.
     *
     * @return void
     */
    public function onConstruct(): void
    {
        $this->service = $this->getDI()->getShared(CategoryService::class);
        $this->validation = $this->getDI()->getShared(CategoryValidation::class);
        $this->responseHelper = $this->getDI()->getShared(ResponseHelper::class);
    }

    /**
     * Get all categories.
     *
     * @return ResponseInterface
     */
    public function list(): ResponseInterface
    {
        /** @var Resultset $list */
        $list = $this->service->list();

        return $this->responseHelper->send($list);
    }

    /**
     * Get a category by id.
     *
     * @param int $id
     * @return ResponseInterface
     */
    public function view(int $id): ResponseInterface
    {
        try {
            $category = $this->service->view($id);
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send($category);
    }

    /**
     * Save a new category.
     *
     * @return ResponseInterface
     */
    public function add(): ResponseInterface
    {
        // validate the input
        $messages = $this->validation->validate($this->request->getJsonRawBody(true));
        if (count($messages)) {
            return $this->responseHelper->send($messages, 400);
        }

        $category = $this->service->add($this->request->getJsonRawBody(true));

        return $this->responseHelper->send($category, 201);
    }

    /**
     * Edit an existing category.
     *
     * @param int $id
     * @return ResponseInterface
     */
    public function edit(int $id): ResponseInterface
    {
        // validate the input
        $messages = $this->validation->validate($this->request->getJsonRawBody(true));
        if (count($messages)) {
            return $this->responseHelper->send($messages, 400);
        }

        try {
            $category = $this->service->edit($id, $this->request->getJsonRawBody(true));
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send($category);
    }

    /**
     * Delete a category.
     *
     * @param int $id
     * @return ResponseInterface
     */
    public function delete(int $id): ResponseInterface
    {
        try {
            $this->service->delete($id);
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send(null, 204);
    }

    /**
     * Get all articles for a category.
     *
     * @param int $id
     * @return ResponseInterface
     */
    public function articles(int $id): ResponseInterface
    {
        try {
            /** @var Resultset $list */
            $list = $this->service->listArticles($id);
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send($list);
    }

    /**
     * Add an article to a category.
     *
     * @param int $id
     * @param int $articleId
     * @return ResponseInterface
     */
    public function addArticle(int $id, int $articleId): ResponseInterface
    {
        try {
            $this->service->addArticle($id, $articleId);
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send(null, 200);
    }

    /**
     * Delete an article from a category.
     *
     * @param int $id
     * @param int $articleId
     * @return ResponseInterface
     */
    public function deleteArticle(int $id, int $articleId): ResponseInterface
    {
        try {
            $this->service->deleteArticle($id, $articleId);
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send(null, 200);
    }
}
