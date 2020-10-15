<?php

namespace App\Controller;

use App\Exception\BaseException;
use App\Helper\ResponseHelper;
use App\Service\OwnerService;
use App\Validation\ImageValidation;
use App\Validation\OwnerValidation;
use Exception;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Resultset;

class OwnerController extends Controller
{
    private OwnerService $service;

    private OwnerValidation $validation;

    private ImageValidation $imageValidation;

    private ResponseHelper $responseHelper;

    /**
     * Set the helpers on construct.
     */
    public function onConstruct(): void
    {
        $this->service = $this->getDI()->getShared(OwnerService::class);
        $this->validation = $this->getDI()->getShared(OwnerValidation::class);
        $this->imageValidation = $this->getDI()->getShared(ImageValidation::class);
        $this->responseHelper = $this->getDI()->getShared(ResponseHelper::class);
    }

    /**
     * Get all owners.
     */
    public function list(): ResponseInterface
    {
        /** @var Resultset $list */
        $list = $this->service->list();

        return $this->responseHelper->send($list);
    }

    /**
     * Get an owner by id.
     */
    public function view(int $id): ResponseInterface
    {
        try {
            $owner = $this->service->view($id);
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send($owner);
    }

    /**
     * Save a new owner.
     */
    public function add(): ResponseInterface
    {
        // validate the input
        $messages = $this->validation->validate($this->request->getPost());
        if (count($messages)) {
            return $this->responseHelper->send($messages, 400);
        }

        // validate the image
        $messages = $this->imageValidation->validate($_FILES);
        if (count($messages)) {
            return $this->responseHelper->send($messages, 400);
        }

        $owner = $this->service->add($this->request->getPost());

        return $this->responseHelper->send($owner, 201);
    }

    /**
     * Edit an existing owner.
     */
    public function edit(int $id): ResponseInterface
    {
        // validate the input
        $data = array_merge(['id' => $id], $this->request->getPost());
        $messages = $this->validation->validate($data);
        if (count($messages)) {
            return $this->responseHelper->send($messages, 400);
        }

        // validate the image
        $messages = $this->imageValidation->validate($_FILES);
        if (count($messages)) {
            return $this->responseHelper->send($messages, 400);
        }

        try {
            $owner = $this->service->edit($id, $this->request->getPost());
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send($owner);
    }

    /**
     * Delete an owner.
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
}
