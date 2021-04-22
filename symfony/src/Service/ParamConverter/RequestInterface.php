<?php

namespace App\Service\ParamConverter;

interface RequestInterface
{
    public function setPayload(array $payload = []);

    public function rules();

    public function get(string $name, $default = null);

    public function has(string $name): bool;

    public function all(): array;
}
