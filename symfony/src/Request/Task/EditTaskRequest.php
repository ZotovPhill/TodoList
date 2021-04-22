<?php

namespace App\Request\Task;

use App\DBAL\Type\TaskStatus;
use App\Service\ParamConverter\RequestObject;
use Symfony\Component\Validator\Constraints as Assert;

class EditTaskRequest extends RequestObject
{
    public function rules()
    {
        return new Assert\Collection([
            'fields' => [
                'title' => [
                    new Assert\Optional([
                        new Assert\NotBlank(),
                        new Assert\Type(['type' => 'string']),
                        new Assert\Length(['max' => 255]),
                    ]),
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
                'status' => [
                    new Assert\Optional([
                        new Assert\Type(['type' => 'string']),
                        new Assert\Choice(TaskStatus::getValues())
                    ])
                ],
            ],
        ]);
    }

    public function hasTitle(): bool
    {
        return $this->has('title');
    }

    public function hasDescription(): bool
    {
        return $this->has('description');
    }

    public function hasStatus(): bool
    {
        return $this->has('status');
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

    public function getStatus(): string
    {
        return $this->get('status');
    }
}