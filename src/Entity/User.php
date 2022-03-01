<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 64)]
    private $name;

    #[ORM\Column(type: 'string', length: 64)]
    private $password;

    #[ORM\Column(type: 'string', length: 64)]
    private $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $avatarAddress;

    #[ORM\Column(type: 'datetime')]
    private $createdTime;

    #[ORM\Column(type: 'datetime')]
    private $updatedTime;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: TaskList::class, orphanRemoval: true)]
    private $TaskList;

    public function __construct()
    {
        $this->TaskList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function  setId(int $id): void
    {
        $this->id=$id;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatarAddress(): ?string
    {
        return $this->avatarAddress;
    }

    public function setAvatarAddress(?string $avatarAddress): self
    {
        $this->avatarAddress = $avatarAddress;

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

    /**
     * @return Collection<int, TaskList>
     */
    public function getTaskList(): Collection
    {
        return $this->TaskList;
    }

    public function addList(TaskList $TaskList): self
    {
        if (!$this->TaskList->contains($TaskList)) {
            $this->TaskList[] = $TaskList;
            $TaskList->setUserId($this);
        }

        return $this;
    }

    public function removeList(TaskList $TaskList): self
    {
        if ($this->TaskList->removeElement($TaskList)) {
            // set the owning side to null (unless already changed)
            if ($TaskList->getUserId() === $this) {
                $TaskList->setUserId(null);
            }
        }

        return $this;
    }
}
