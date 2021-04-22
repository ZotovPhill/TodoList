<?php

namespace App\Handler\Task;

use App\Entity\Task\Task;
use App\Repository\Task\TaskRepository;
use App\Request\Task\CreateTaskRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateTaskService
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

    public function __invoke(CreateTaskRequest $request): void
    {
        if ($parent = $request->getParent()) {
            $parent = $this->repository->find($parent);
            if (!$parent) {
                throw new NotFoundHttpException('Parent task not found');
            }
        }

        $task = new Task($parent, $request->getTitle(), $request->getDescription());
        $this->em->persist($task);
    }
}