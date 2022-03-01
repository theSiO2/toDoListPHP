<?php

namespace App\Factory;
use App\Entity\TaskList;
use App\Entity\User;
use App\Kernel;

class TaskListFactory
{


    private Kernel $Kernel;

    public function __construct(Kernel $kernel)
    {
        $this->Kernel = $kernel;
    }


    public  function createList(string $name, User $user): TaskList
    {

        $TaskList=new TaskList();
        $newTime=new \DateTime();
        //设置时区
        $timezone = new \DateTimeZone('Asia/Shanghai');
        $newTime->setTimezone($timezone);

        $TaskList->setName($name);
        $TaskList->setUserId($user);
        $TaskList->setCreatedTime($newTime);
        $TaskList->setUpdatedTime($newTime);
        $entityManager = $this->Kernel->getContainer()->get('doctrine.orm.entity_manager');
        $entityManager->persist($TaskList);
        $entityManager->flush();
        //返回创建的Task对象
        return $TaskList;
    }


}