<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\Validator\Constraints\DateTime;

class UserFactory
{
    public function create(string $name, string $password, string $email, string $avatarAddress):User
    {
        $newUser=new User();

        $newUser->setName($name);
        $newUser->setPassword($password);
        $newUser->setEmail($email);
        $newUser->setAvatarAddress($avatarAddress);

        $newTime=new \DateTime();
        $newUser->setCreatedTime($newTime);
        $newUser->setUpdatedTime($newTime);

        return $newUser;
    }
}