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
     */
    public function onConstruct(): void
    {
        $this->service = $this->getDI()->getShared(CategoryService::class);
        $this->validation = $this->getDI()->getShared(CategoryValidation::class);
        $this->responseHelper = $this->getDI()->getShared(ResponseHelper::class);
    }

    /**
     * Get all categories.
     */
    public function list(): ResponseInterface
    {
        /** @var Resultset $list */
        $list = $this->service->list();

        return $this->responseHelper->send($list);
    }

    /**
     * Get a category by id.
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
     * Get all animals for a category.
     */
    public function animals(int $id): ResponseInterface
    {
        try {
            /** @var Resultset $list */
            $list = $this->service->listAnimals($id);
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send($list);
    }

    /**
     * Add an animal to a category.
     */
    public function addAnimal(int $id, int $animalId): ResponseInterface
    {
        try {
            $this->service->addAnimal($id, $animalId);
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send(null, 200);
    }

    /**
     * Delete an animal from a category.
     */
    public function deleteAnimal(int $id, int $animalId): ResponseInterface
    {
        try {
            $this->service->deleteAnimal($id, $animalId);
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send(null, 200);
    }
}
