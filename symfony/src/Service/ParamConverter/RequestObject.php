<?php

namespace App\Service\ParamConverter;

use Symfony\Component\Validator\Constraints\GroupSequence;

abstract class RequestObject implements RequestInterface
{
    private $payload = [];

    public function setPayload(array $payload = []): void
    {
        $this->payload = $payload;
    }

    public function rules()
    {
        return null;
    }

    public function groups(): ?GroupSequence
    {
        return null;
    }

    public function get(string $name, $default = null)
    {
        return $this->has($name) ? $this->payload[$name] : $default;
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->payload);
    }

    public function all(): array
    {
        return $this->payload;
    }
}
