<?php

namespace App\Repository;

use App\Entity\Basket;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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

//    public function getUserById($id)
//    {
//        return $this->createQueryBuilder('u')
//            ->select('u.id')
//            ->where('u.id = :id')
//            ->setParameter("id", $id)
//            ->getQuery()
//            ->getResult();
//    }

    public function getUsersCount()
    {
        return $this->createQueryBuilder('u')
            ->select('Count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
