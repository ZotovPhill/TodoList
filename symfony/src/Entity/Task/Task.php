<?php

namespace App\Entity\Task;

use App\DBAL\Type\TaskStatus;
use App\Repository\Task\TaskRepository;
use App\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\Table(name="tsk_Task")
 */

class Task extends BaseEntity
{
    /**
     * @var Task
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $parent;

    /**
     * @var ArrayCollection|Task[]
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="parent", fetch="EXTRA_LAZY")
     */
    private $children;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", length=4000, nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="level", type="text", nullable=true)
     */
    private $level;

    /**
     * @var string
     * @ORM\Column(name="status", type="TaskStatus")
     */
    private $status;

    public function __construct(?Task $parent, string $title, ?string $description)
    {
        $this->parent = $parent;
        $this->title = $title;
        $this->description = $description;
        $this->status = TaskStatus::CREATED;
        $this->createdAt = new \DateTime();

        $this->setLevel($parent);
    }

    public function getParent(): ?Task
    {
        return $this->parent;
    }

    public function setParent(?Task $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    public function getChildren(): array
    {
        return $this->children->toArray();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?Task $parent): self
    {
        $this->level =  !is_null($parent) ? $parent->getLevel() ?? $parent->getId() . '/' : null;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
}
