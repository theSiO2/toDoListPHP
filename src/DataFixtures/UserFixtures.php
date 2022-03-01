<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private $userFactory;
    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory=$userFactory;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user=$this->userFactory->create("user1","123456@123.com","123@123.com","C:\\Users\\31649\\Desktop\\Code\\toDoListPHP");
        $manager->persist($user);
        $manager->flush();
    }
}
