<?php

namespace App\Service;

use App\Entity\TaskList;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public  function getUser(int $userId): User
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        return $userRepository->findUserObjByUserID($userId);
    }
}