<?php

namespace App\Exception;

use App\Service\ParamConverter\RequestObject;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestObjectPayloadException extends HttpException
{
    private $requestObject;
    private $errors;

    public function __construct(RequestObject $requestObject, ConstraintViolationListInterface $errors)
    {
        $this->requestObject = $requestObject;
        $this->errors = $errors;
        parent::__construct(JsonResponse::HTTP_BAD_REQUEST, 'Request contains errors');
    }

    public function getRequestObject(): RequestObject
    {
        return $this->requestObject;
    }

    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}
