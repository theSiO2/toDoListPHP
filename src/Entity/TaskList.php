<?php

namespace App\Entity;

use App\Repository\TaskListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskListRepository::class)]
class TaskList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 64)]
    private $name;

    #[ORM\Column(type: 'datetime')]
    private $createdTime;

    #[ORM\Column(type: 'datetime')]
    private $updatedTime;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'TaskList')]
    #[ORM\JoinColumn(nullable: false)]
    private $userId;

    #[ORM\OneToMany(mappedBy: 'taskListId', targetEntity: Task::class, orphanRemoval: true)]
    private $Tasks;

    public function __construct()
    {
        $this->Tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public  function setId(int $id) :self
    {
        $this->id=$id;

        return $this;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getCreatedTime(): ?\DateTimeInterface
    {
        return $this->createdTime;
    }

    public function setCreatedTime(\DateTimeInterface $createdTime): self
    {
        $this->createdTime = $createdTime;

        return $this;
    }

    public function getUpdatedTime(): ?\DateTimeInterface
    {
        return $this->updatedTime;
    }

    public function setUpdatedTime(\DateTimeInterface $updatedTime): self
    {
        $this->updatedTime = $updatedTime;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->Tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->Tasks->contains($task)) {
            $this->Tasks[] = $task;
            $task->setTaskListId($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->Tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getTaskListId() === $this) {
                $task->setTaskListId(null);
            }
        }

        return $this;
    }
}
