<?php

namespace App\Controller;

use App\Exception\BaseException;
use App\Helper\ResponseHelper;
use App\Service\AnimalService;
use App\Validation\AnimalValidation;
use Exception;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Resultset;

class AnimalController extends Controller
{
    private AnimalService $service;

    private AnimalValidation $validation;

    private ResponseHelper $responseHelper;

    /**
     * Set the helpers on construct.
     */
    public function onConstruct(): void
    {
        $this->service = $this->getDI()->getShared(AnimalService::class);
        $this->validation = $this->getDI()->getShared(AnimalValidation::class);
        $this->responseHelper = $this->getDI()->getShared(ResponseHelper::class);
    }

    /**
     * Get all animals.
     */
    public function list(): ResponseInterface
    {
        /** @var Resultset $list */
        $list = $this->service->list();

        return $this->responseHelper->send($list);
    }

    /**
     * Get an animal by id.
     */
    public function view(int $id): ResponseInterface
    {
        try {
            $animal = $this->service->view($id);
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send($animal);
    }

    /**
     * Save a new animal.
     */
    public function add(): ResponseInterface
    {
        // validate the input
        $messages = $this->validation->validate($this->request->getJsonRawBody(true));
        if (count($messages)) {
            return $this->responseHelper->send($messages, 400);
        }

        try {
            $animal = $this->service->add($this->request->getJsonRawBody(true));
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send($animal, 201);
    }

    /**
     * Edit an existing animal.
     */
    public function edit(int $id): ResponseInterface
    {
        // validate the input
        $messages = $this->validation->validate($this->request->getJsonRawBody(true));
        if (count($messages)) {
            return $this->responseHelper->send($messages, 400);
        }

        try {
            $animal = $this->service->edit($id, $this->request->getJsonRawBody(true));
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send($animal);
    }

    /**
     * Delete an animal.
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
     * Get all categories for an animal.
     */
    public function categories(int $id): ResponseInterface
    {
        try {
            /** @var Resultset $list */
            $list = $this->service->listCategories($id);
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send($list);
    }
}
