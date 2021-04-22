<?php

namespace App\Controller\Task;

use App\Controller\BaseController;
use App\Entity\Task\Task;
use App\Handler\Task\CreateTaskService;
use App\Handler\Task\EditTaskService;
use App\Repository\Task\TaskRepository;
use App\Request\Task\CreateTaskRequest;
use App\Request\Task\EditTaskRequest;
use App\Service\QueryModifier\Task\TaskListModifier;
use App\Transformer\Task\TaskListTransformer;
use App\Transformer\Task\TaskViewTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("task")
 */
class TaskController extends BaseController
{
    /**
     * @Route("", name="task_list", methods={"GET"})
     */
    public function list(
        TaskRepository $repository,
        TaskListTransformer $transformer
    ): JsonResponse {
        return $this->collection(
            $repository->getList(new TaskListModifier(), true),
            $transformer
        );
    }

    /**
     * @Route("", name="task_create", methods={"POST"})
     */
    public function create(
        CreateTaskRequest $request,
        CreateTaskService $service,
        EntityManagerInterface $em
    ): JsonResponse {
        $service($request);
        $em->flush();
        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/{task}", name="task_view", methods={"GET"})
     */
    public function view(
        Task $task,
        TaskViewTransformer $transformer
    ): JsonResponse {
        return $this->item($task, $transformer);
    }

    /**
     * @Route("/{task}", name="task_edit", methods={"PUT"})
     */
    public function edit(
        Task $task,
        EditTaskRequest $request,
        EditTaskService $service,
        EntityManagerInterface $em,
        TaskViewTransformer $transformer
    ): JsonResponse {
        $service($task, $request);
        $em->flush();
        return $this->item($task, $transformer);
    }

    /**
     * @Route("/{task}", name="task_delete", methods={"DELETE"})
     */
    public function delete(Task $task, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($task);
        $em->flush();
        return new JsonResponse([], JsonResponse::HTTP_NO_CONTENT);
    }
}
