<?php


namespace App\Service\ParamConverter;


class Pagination
{
    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 20;

    private $limit;
    private $offset;
    private $beforeTime;
    private $afterId;

    public function __construct(
        int $offset = self::DEFAULT_OFFSET,
        int $limit = self::DEFAULT_LIMIT,
        ?int $beforeTime = null,
        ?int $afterId = null
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->beforeTime = $beforeTime;
        $this->afterId = $afterId;
    }

    public function update(
        int $offset = self::DEFAULT_OFFSET,
        int $limit = self::DEFAULT_LIMIT,
        ?int $beforeTime = null,
        ?int $afterId = null
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->beforeTime = $beforeTime;
        $this->afterId = $afterId;
    }

    public function getLimit(): int
    {
        return $this->limit <= 0 ? 1 : $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getBeforeTime(): ?int
    {
        return $this->beforeTime;
    }

    public function getAfterId(): ?int
    {
        return $this->afterId;
    }
}
