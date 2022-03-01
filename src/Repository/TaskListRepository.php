<?php

namespace App\Repository;

use App\Entity\TaskList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * @method TaskList|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskList|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskList[]    findAll()
 * @method TaskList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskList::class);
    }


    //通过用户ID返回属于该用户所有的列表信息
    public function findAllByUserID(int $userId): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\TaskList p
            WHERE p.userId = :userId'
        )->setParameter('userId', $userId);
        return $query->getResult();
    }
    //通过列表ID删除该列表的信息
    public function  deleteListByListId(int $listId):TaskList
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'DELETE a
            FROM App\Entity\TaskList a
            WHERE a.id = :listId'
        )->setParameter('listId', $listId);
        return $query->getResult();
    }
    //通过列表ID找到该列表的信息
    public function findListByListId(int $listId):array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\TaskList p
            WHERE p.id = :listId'
        )->setParameter('listId', $listId);
        return $query->getResult();
    }




    // /**
    //  * @return TaskList[] Returns an array of TaskList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TaskList
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
