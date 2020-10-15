<?php

namespace App\Controller;

use App\Exception\BaseException;
use App\Helper\ResponseHelper;
use App\Service\AuthorService;
use App\Validation\AuthorValidation;
use App\Validation\ImageValidation;
use Exception;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Resultset;

class AuthorController extends Controller
{
    private AuthorService $service;

    private AuthorValidation $validation;

    private ImageValidation $imageValidation;

    private ResponseHelper $responseHelper;

    /**
     * Set the helpers on construct.
     *
     * @return void
     */
    public function onConstruct(): void
    {
        $this->service = $this->getDI()->getShared(AuthorService::class);
        $this->validation = $this->getDI()->getShared(AuthorValidation::class);
        $this->imageValidation = $this->getDI()->getShared(ImageValidation::class);
        $this->responseHelper = $this->getDI()->getShared(ResponseHelper::class);
    }

    /**
     * Get all authors.
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
     * Get an author by id.
     *
     * @param int $id
     * @return ResponseInterface
     */
    public function view(int $id): ResponseInterface
    {
        try {
            $author = $this->service->view($id);
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send($author);
    }

    /**
     * Save a new author.
     *
     * @return ResponseInterface
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

        $author = $this->service->add($this->request->getPost());

        return $this->responseHelper->send($author, 201);
    }

    /**
     * Edit an existing author.
     *
     * @param int $id
     * @return ResponseInterface
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
            $author = $this->service->edit($id, $this->request->getPost());
        } catch (Exception $exception) {
            return $this->responseHelper->send(
                $exception->getMessage(),
                ($exception instanceof BaseException) ? $exception->getCode() : 500
            );
        }

        return $this->responseHelper->send($author);
    }

    /**
     * Delete an author.
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
}
