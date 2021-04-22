<?php

namespace App\Service\QueryModifier;

use Doctrine\ORM\QueryBuilder;

interface QueryModifierInterface
{
    public function modify(QueryBuilder $qb, string $alias);
}