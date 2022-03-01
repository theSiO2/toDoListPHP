<?php

namespace App\Tests;

use App\Entity\TaskList;
use App\Service\ListService;
use Doctrine\DBAL\Types\IntegerType;
use phpDocumentor\Reflection\Types\ArrayKey;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;



class ListServiceTest extends KernelTestCase
{
    public function testGetListData(): void
    {
        $kernel = self::bootKernel();
        $this->assertSame('test', $kernel->getEnvironment());
        $listService = static::getContainer()->get(ListService::class);
        $listArr = $listService->getListData(1);
        foreach ($listArr as $index => $obj)
        {
            $this->assertInstanceOf(TaskList::class,$obj);
        }
    }

    public function testObjArrToArr():void
    {
        $kernel = self::bootKernel();
        $this->assertSame('test', $kernel->getEnvironment());
        $listService = static::getContainer()->get(ListService::class);
        $entityManager = static ::getContainer()->get('doctrine.orm.entity_manager');
        $query = $entityManager->createQuery(
            'SELECT p.id
            FROM App\Entity\User p'
        );
        $userArr=$query->getResult();//所有用户的ID
//        foreach ($userArr as $index => $userObj) {
            $listArr = $listService->getListData($userArr[0]["id"]);//根据用户ID获取list
            $strArr = $listService->objArrToArr($listArr);
            foreach ($strArr as $index => $obj) {
                $this->assertArrayHasKey("listId", $obj);
                $this->assertArrayHasKey("listName", $obj);
                $this->assertArrayHasKey("userId", $obj);
                $this->assertArrayHasKey("createdTime", $obj);
                $this->assertArrayHasKey("updatedTime", $obj);
            }
//        }
    }
}
