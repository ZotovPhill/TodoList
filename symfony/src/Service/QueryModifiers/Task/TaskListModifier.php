<?php

namespace App\Service\QueryModifier\Task;

use App\Service\QueryModifier\QueryModifierInterface;
use Doctrine\ORM\QueryBuilder;

class TaskListModifier implements QueryModifierInterface
{
    public function modify(QueryBuilder $qb, string $alias)
    {
        return $qb
            ->andWhere("$alias.parent IS NULL");
    }
}