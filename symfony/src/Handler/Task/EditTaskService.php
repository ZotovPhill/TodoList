<?php

namespace App\Handler\Task;

use App\Entity\Task\Task;
use App\Repository\Task\TaskRepository;
use App\Request\Task\EditTaskRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EditTaskService
{
    private $repository;
    private $em;

    public function __construct(
        TaskRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function __invoke(Task $task, EditTaskRequest $request)
    {
        if ($parent = $request->getParent()) {
            $parent = $this->repository->find($parent);
            if (!$parent) {
                throw new NotFoundHttpException('Parent task not found');
            }
        }

        $task
            ->setParent($parent ?? $task->getParent())
            ->setTitle($request->hasTitle() ? $request->getTitle() : $task->getTitle())
            ->setDescription($request->hasDescription() ? $request->getDescription() : $task->getDescription())
            ->setStatus($request->hasStatus() ? $request->getStatus() : $task->getStatus());
    }
}