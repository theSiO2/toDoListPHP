<?php

namespace App\Tests;

use App\Entity\TaskList;
use App\Repository\TaskListRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskListReponsitoryTest extends KernelTestCase
{
    public function testFindAllByUserID(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        $repository=static::getContainer()->get(TaskListRepository::class);
        $entityManager = static ::getContainer()->get('doctrine.orm.entity_manager');
        $query = $entityManager->createQuery(
            'SELECT p.id
            FROM App\Entity\User p'
        );
        $userArr=$query->getResult();//所有用户的ID
        $listArr=$repository->findAllByUserID($userArr[0]["id"]);
        foreach ($listArr as $index => $listObj)
        {
            $this->assertInstanceOf(TaskList::class,$listObj);
        }
    }
}
