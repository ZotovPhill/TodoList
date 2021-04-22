<?php

namespace App\Request\Task;

use App\Service\ParamConverter\RequestObject;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTaskRequest extends RequestObject
{
    public function rules()
    {
        return new Assert\Collection([
            'fields' => [
                'title' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'string']),
                    new Assert\Length(['max' => 255]),
                ],
                'description' => [
                    new Assert\Optional([
                        new Assert\Type(['type' => 'string']),
                    ]),
                ],
                'parent' => [
                    new Assert\Optional([
                        new Assert\Type(['type' => 'int']),
                    ]),
                ],
            ],
        ]);
    }

    public function getTitle(): string
    {
        return $this->get('title');
    }

    public function getDescription(): ?string
    {
        return $this->get('description');
    }

    public function getParent(): ?int
    {
        return $this->get('parent');
    }
}