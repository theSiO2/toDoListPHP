<?php

namespace App\Tests;

use App\Entity\TaskList;
use App\Factory\TaskListFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskListFactoryTest extends KernelTestCase
{
    public function testCreateList(): void
    {
        $kernel = self::bootKernel();
        $this->assertSame('test', $kernel->getEnvironment());
        $listFactory = static::getContainer()->get(TaskListFactory::class);
        $listName="newList_test";
        $entityManager = static ::getContainer()->get('doctrine.orm.entity_manager');
        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\User p'
        );
        $userArr=$query->getResult();//所有用户的对象
        $newList=$listFactory->createList($listName,$userArr[0]);
        $this->assertInstanceOf(TaskList::class,$newList);

    }
}
