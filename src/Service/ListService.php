<?php

namespace App\Service;
use App\Entity\TaskList;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Response;
class ListService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    //根据用户ID获取所有的列表信息
    public function getListData(int $userId): array
    {
        $taskListRepository = $this->entityManager->getRepository(TaskList::class);
        $data=$taskListRepository->findAllByUserId($userId);
        return $data;
    }


    //将查询对象转成二维数组
    static function objArrToArr(array $objArr):array
    {
        $responseData = array();
        foreach ($objArr as $index => $obj)
        {
            $responseData[$index]['listId']=$obj->getId();
            $responseData[$index]['listName']=$obj->getName();
            $responseData[$index]['userId']=$obj->getUserId()->getId();
            $responseData[$index]['createdTime']=$obj->getCreatedTime()->format("Y-m-d H:i:s");
            $responseData[$index]['updatedTime']=$obj->getUpdatedTime()->format("Y-m-d H:i:s");
        }
        //将二维数组转成JSON
        $temp["listData"]=$responseData;
        return $temp["listData"];
    }


//    //判断该列表ID是否属于该用户
//    public function isListBelongsToUser(int $userId,int $listId):bool
//    {
//        $taskListRepository = $this->entityManager->getRepository(TaskList::class);
//        $uId = $taskListRepository->findListByListId($listId)[0]->getUserId()->getId();
//        if($uId==$userId)
//            return true;
//        else
//            return false;
//    }
//





    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}