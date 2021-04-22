<?php

namespace App\Controller;

use App\Service\ParamConverter\Pagination;
use App\Transformer\AbstractTransformer;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class BaseController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getRequest(): ?Request
    {
        return $this->requestStack->getMasterRequest();
    }

    protected function item($data, AbstractTransformer $transformer, array $metadata = []): JsonResponse
    {
        $headers = $metadata['headers'] ?? [];

        return $this->json($transformer->transform($data), JsonResponse::HTTP_OK, $headers);
    }

    protected function collection($data, AbstractTransformer $transformer, array $metadata = []): JsonResponse
    {
        if ($headers = $metadata['headers'] ?? []) {
            unset($metadata['headers']);
        }

        if ($data instanceof Paginator) {
            $pagination = new Pagination();

            $metadata['pagination'] = [
                'offset' => $pagination->getOffset(),
                'limit' => $pagination->getLimit() ?? 0,
                'total' => count($data),
            ];

        }

        $metadata['data'] = [];
        if (is_iterable($data)) {
            foreach ($data as $item) {
                if ($result = $transformer->transform($item)) {
                    $metadata['data'][] = $result;
                }
            }
        }

        return $this->json($metadata, JsonResponse::HTTP_OK, $headers);
    }
}
