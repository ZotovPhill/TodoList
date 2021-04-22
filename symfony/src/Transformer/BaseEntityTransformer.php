<?php

namespace App\Transformer;

use App\Entity\BaseEntity;

class BaseEntityTransformer extends ShortBaseEntityTransformer
{
    protected function doEntityTransform(BaseEntity $entity): array
    {
        $data = [
            'id' => $entity->getId(),
            'createdAt' => $this->transformDateTime($entity->getCreatedAt()),
            'updatedAt' => $this->transformDateTime($entity->getUpdatedAt()),
        ];

        return $data;
    }
}
