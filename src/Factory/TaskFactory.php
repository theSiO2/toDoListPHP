<?php

namespace App\Factory;

use App\Entity\State;
use App\Entity\Task;
use App\Entity\TaskList;
class TaskFactory
{

    public function create(string $name, string $description,TaskList $taskListId,State $stateId,\DateTime $startTime,\DateTime $endTime)
    {
        $task=new Task();
        $newTime=new \DateTime();

        $task->setName($name);
        $task->setDescrptions($description);
        $task->setTaskListId($taskListId);
        $task->setStateId($stateId);
        $task->setCreatedTime($newTime);
        $task->setUpdatedTime($newTime);
        $task->setStartTime($startTime);
        $task->setEndTime($endTime);


        return $task;
    }
}