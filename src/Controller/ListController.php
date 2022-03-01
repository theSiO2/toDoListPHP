<?php

namespace App\Controller;

use App\Entity\TaskList;
use App\Factory\TaskListFactory;
use App\Repository\TaskListRepository;
use App\Service\Tokenhg;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ListService;


class ListController extends AbstractController
{
    private ListService $listService;
    private UserService $userService;
    private TaskListFactory $taskListFactory;
    private EntityManagerInterface $entityManager;
    private TaskListRepository $taskListRepository;

    public function __construct(ListService $listService, UserService $userService,TaskListFactory $taskListFactory,EntityManagerInterface $entityManager,TaskListRepository $taskListRepository)
    {
        $this->listService = $listService;
        $this->userService = $userService;
        $this->taskListFactory=$taskListFactory;
        $this->entityManager=$entityManager;
        $this->taskListRepository=$taskListRepository;
    }

    //根据token获取用户的所有列表信息
    #[Route('/list', name: 'getListsByUser',methods: ['GET']),]
    public function getListsByUser(Request $request): Response
    {
        //获取查询对象
        $token = $request->query->get('token','');
        $userId = Tokenhg::getID($token);
        $lists = $this->listService->getListData($userId);

        //将查询对象集合转换成普通数组
        $responseData = $this->listService->objArrToArr($lists);
        $responseObj["listData"]=$responseData;

        //将JSON(该用户的所有列表)返回给浏览器
        $response = new Response();
        return $response->setContent(json_encode($responseObj));
    }

    //根据token和列表ID获取用户的所有列表信息
    #[Route('/list/{listId}', name: 'getList',methods: ['GET']),]
    public function getList(Request $request): Response
    {
        //获取查询对象
        $token = $request->query->get('token','');
        $userId = Tokenhg::getID($token);
        $listId = $request->get('listId');
        $responseData = "";
//        //验证用户ID,判断是否进行操作
//        $isDelete = $this->listService->isListBelongsToUser($userId,$listId);
//        if($isDelete)//查看操作
//        {
//            $responseData=$this->listService->objArrToArr($this->taskListRepository->findListByListId($listId));
//        } else {
//            $listId = ("暂无该表权限");
//        }

        //查看操作
        $responseData=$this->listService->objArrToArr($this->taskListRepository->findListByListId($listId));
        $temp["listData"] = $responseData;
        $responseData=$temp;
        $response = new Response();
        return $response->setContent(json_encode($responseData));
    }

    //根据token增加列表信息
    #[Route('/list', name: 'addList',methods: ['POST']) ]
    public function addList(Request $request): Response
    {
        //获取查询对象
        $listName = $request->query->get('listName','');
        $token = $request->query->get('token','');
        //通过token获取用户ID
        $userId = Tokenhg::getID($token);

        //通过用户ID获取用户对象
        $userObj = $this->userService->getUser($userId);
        $listId = $this->taskListFactory->createList($listName,$userObj)->getId();

        //设置key
        $ListId["listId"] = $listId;

        //将JSON(用户ID)返回给浏览器
        $response = new Response();
        return $response->setContent(json_encode($ListId));
    }

    //根据ListId删除单个列表信息
    #[Route('/list', name: 'deleteList',methods: ['DELETE']) ]
    public function deleteListByUserId(Request $request): Response
    {
        $listId = $request->query->get('listId','');
        $token = $request->query->get('token','');
        //通过token获取用户ID
        $userId = Tokenhg::getID($token);
        //验证用户ID,判断是否进行操作
//        $isDelete=$this->listService->isListBelongsToUser($userId,$listId);
//        if($isDelete)//删除操作
//        {
//            $this->entityManager->remove($this->taskListRepository->findListByListId($listId)[0]);
//            $this->entityManager->flush();
//        } else
//        {
//
//        }
        //删除操作
        $this->entityManager->remove($this->taskListRepository->findListByListId($listId)[0]);
        $this->entityManager->flush();
        //设置key
        $ListId["listId"] = $listId;
        $response = new Response();
        return $response->setContent(json_encode($ListId));
    }

    //根据ListId和token更新单个列表信息
    #[Route('/list', name: 'updateList',methods: ['PUT']) ]
    public function updateListByUserId(Request $request): Response
    {
        //获取参数
        $token = $request->query->get('token','');
        $listId = $request->query->get('listId','');
        $listName = $request->query->get('listName','');
        $userId = Tokenhg::getID($token);
        //更新操作
        $product = $this->entityManager->getRepository(TaskList::class)->find($listId);
        $product->setName($listName);
        $newTime = new \DateTime();            //设置时间
        $timezone = new \DateTimeZone('Asia/Shanghai');
        $newTime->setTimezone($timezone);
        $product->setUpdatedTime($newTime);
        $this->entityManager->flush();
//        dd($product->getUpdatedTime());
        //返回值
        $responseJson["listId"]=$listId;
        $response = new Response();
        return $response->setContent(json_encode($responseJson));
    }
}
