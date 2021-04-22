<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class BodyListener {

    private $serializer;

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

    public function onKernelRequest(RequestEvent $event): void {
        $request = $event->getRequest();
        $contentType = $request->headers->get('Content-Type');

        if ($this->isDecodable($request)) {
            $format = null === $contentType
                ? $request->getRequestFormat()
                : $request->getFormat($contentType);

            $content = $request->getContent();

            if (!empty($content) && $this->serializer->supportsDecoding($format)) {
                $data = $this->serializer->decode($content, $format);

                if (is_array($data)) {
                    $request->request = new ParameterBag($data);
                }
                else {
                    throw new BadRequestHttpException('Invalid ' . $format . ' message received');
                }
            }
        }
    }

    /**
     * Check if we should try to decode the body.
     */
    private function isDecodable(Request $request): bool
    {
        return in_array($request->getMethod(), [
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
        ]) || !$this->isFormRequest($request);
    }

    /**
     * Check if the content type indicates a form submission.
     */
    private function isFormRequest(Request $request): bool
    {
        $contentTypeParts = explode(';', $request->headers->get('Content-Type'));

        if (isset($contentTypeParts[0])) {
            return in_array($contentTypeParts[0], [
                'multipart/form-data',
                'application/x-www-form-urlencoded',
            ]);
        }

        return false;
    }
}
