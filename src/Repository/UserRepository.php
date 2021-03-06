<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function  getUser(){
//        return $this->createQueryBuilder('query')
//            ->select('u.userName,u.address,o.date')
//            ->from(User::class, 'u')
//            ->join(Order::class,'o')
//            ->where('u.id = o.user')
//            ->getQuery()
//            ->getResult();
//    }
        return $this->createQueryBuilder('q')
            ->select('q.userName,q.address')
            ->join('q.orders','o')
            ->getQuery()
            ->getResult();
    }

}
