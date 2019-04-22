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

//    public function showBasketList()
//    {
//        return $this->createQueryBuilder('query')
//            ->select('p')
//            ->from(Product::class, 'p')
//            ->innerJoin(Basket::class, 'b')
//            ->where('p.id = b.product_id')
//            ->getQuery()
//            ->getResult();
//    }


    public function deleteBasketList()
    {
        return $this->createQueryBuilder('query')
            ->delete(Basket::class,'b')
            ->getQuery()
            ->getResult();
    }

    public function deleteProductFromBasket($id)
    {
        return $this->createQueryBuilder('query')
            ->delete(Basket::class,'b')
            ->where('b.product_id = :id')
            ->setParameter("id", $id)
            ->getQuery()
            ->getResult();
    }

    public function  getBasketUser(){
        return $this->createQueryBuilder('b')
            ->select(['b.id','u.userName'])
            ->innerJoin(User::class,'u',Join::WITH,'u.id = b.user')
            ->getQuery()
            ->getResult();
    }


}
