<?php

namespace App\Repository;

use App\Service\QueryModifier\QueryModifierInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

abstract class CollectionRepository extends ServiceEntityRepository
{
    const MAIN_ALIAS = 'entity';

    public function getList(
        ?QueryModifierInterface $modifier = null,
        bool $paginate = false,
        bool $fetchJoinCollection = false
    )
    {
        $alias = static::MAIN_ALIAS;

        $qb = $this->createQueryBuilder($alias);
        if ($modifier) {
            $modifier->modify($qb, $alias);
        }

        $query = $qb->getQuery();

        if ($paginate) {
            return new Paginator($query, $fetchJoinCollection);
        }

        return $query->getResult();
    }
}
