<?php

namespace App\Transformer\Task;

use App\Entity\Task\Task;
use App\Transformer\BaseEntityTransformer;

class TaskViewTransformer extends BaseEntityTransformer
{
    public function transform($task): array
    {
        $data = array_merge(
            parent::doEntityTransform($task),
            [
                'title' => $task->getTitle(),
                'description' => $task->getDescription(),
                'subtask' => array_map(
                    function (Task $subtask) {
                        return $this->transform($subtask);
                    }, $task->getChildren()
                ),
                'status' => $task->getStatus(),
            ]
        );

        return $data;
    }
}
