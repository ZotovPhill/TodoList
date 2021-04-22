<?php

namespace App\Transformer\Task;

use App\Transformer\ShortBaseEntityTransformer;

class TaskListTransformer extends ShortBaseEntityTransformer
{
    public function transform($task)
    {
        return array_merge(
            parent::doEntityTransform($task),
            [
                'title' => $task->getTitle()
            ]
        );
    }

}