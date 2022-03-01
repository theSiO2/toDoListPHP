<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 64)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $descrptions;



    #[ORM\Column(type: 'datetime')]
    private $createdTime;

    #[ORM\Column(type: 'datetime')]
    private $updatedTime;

    #[ORM\Column(type: 'datetime')]
    private $startTime;

    #[ORM\Column(type: 'datetime')]
    private $endTime;

    #[ORM\ManyToOne(targetEntity: TaskList::class, inversedBy: 'Tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private $taskListId;

    #[ORM\ManyToOne(targetEntity: State::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $stateId;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescrptions(): ?string
    {
        return $this->descrptions;
    }

    public function setDescrptions(?string $descrptions): self
    {
        $this->descrptions = $descrptions;

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

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }



    public function getTaskListId(): ?TaskList
    {
        return $this->taskListId;
    }

    public function setTaskListId(?TaskList $taskListId): self
    {
        $this->taskListId = $taskListId;

        return $this;
    }

    public function getStateId(): ?State
    {
        return $this->stateId;
    }

    public function setStateId(?State $stateId): self
    {
        $this->stateId = $stateId;

        return $this;
    }
}
