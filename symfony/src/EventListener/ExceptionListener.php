<?php

namespace App\EventListener;

use App\Exception\RequestObjectPayloadException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolation;

class ExceptionListener
{
    private $debug;

    public function __construct(
        bool $debug = false
    ) {
        $this->debug = $debug;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $statusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;

        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        }

        if ($exception instanceof RequestObjectPayloadException) {
            $event->setResponse(new JsonResponse([
                'status' => $statusCode,
                'message' => 'Invalid data in request body',
                'errors' => array_map(function (ConstraintViolation $violation) {
                    return [
                        'field' => trim(str_replace('][', '.', $violation->getPropertyPath()), '[]'),
                        'message' => $violation->getMessage(),
                    ];
                }, iterator_to_array($exception->getErrors())),
            ], Response::HTTP_BAD_REQUEST));

            return;
        }


        $response = [
            'status' => $statusCode,
            'timestamp' => (new \DateTime())->format(DATE_RFC3339),
            'message' => $exception->getMessage(),
        ];

        if ($this->debug) {
            $response['trace'] = $exception->getTraceAsString();
        }

        $event->setResponse(
            new JsonResponse($response, $statusCode)
        );
    }
}
