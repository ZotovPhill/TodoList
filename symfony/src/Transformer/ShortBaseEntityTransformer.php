<?php

namespace App\Transformer;

use App\Entity\BaseEntity;
use DateTimeInterface;
use Exception;

class ShortBaseEntityTransformer extends AbstractTransformer
{
    public const DATETIME_FORMAT = DATE_RFC3339;

    /**
     * @param BaseEntity $data
     * @return array|null|void
     * @throws Exception
     */
    public function transform($data)
    {
        if (is_null($data)) {
            return null;
        }

        throw new Exception(sprintf(
            'Failure transform entity "%s"',
            is_object($data) ? get_class($data) : gettype($data)
        ));
    }

    protected function doEntityTransform(BaseEntity $entity): array
    {
        return [
            'id' => $entity->getId(),
        ];
    }

    protected function transformDateTime(?DateTimeInterface $dateTime = null): ?string
    {
        return $dateTime ? $dateTime->format(self::DATETIME_FORMAT) : null;
    }
}
