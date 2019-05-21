<?php

namespace App\Repository;

use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Basket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Basket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Basket[]    findAll()
 * @method Basket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BasketRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Basket::class);
    }

    public function deleteBasket()
    {
        return $this->createQueryBuilder('b')
            ->delete(Basket::class, 'b')
            ->getQuery()
            ->getResult();
    }

    public function  getBasketIdByUserId($userId){
        return $this->createQueryBuilder('b')
            ->select('b.id')
            ->where('b.user = :userId')
            ->setParameter("userId", $userId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
