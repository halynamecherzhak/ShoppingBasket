<?php

namespace App\Repository;

use App\Entity\Basket;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

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

    public function showBasketList()
    {
        return $this->createQueryBuilder('query')
            ->select('p')
            ->from(Product::class, 'p')
            ->innerJoin(Basket::class, 'b')
            ->where('p.product_id = b.product_id')
            ->getQuery()
            ->getResult();
    }

    public function deleteBasketList()
    {
        return $this->createQueryBuilder('query')
            ->delete(Basket::class,'b')
            ->getQuery()
            ->getResult();
    }

    public function deleteProductFromBasket($product_id)
    {
        return $this->createQueryBuilder('query')
            ->delete(Basket::class,'b')
            ->where('b.product_id = :product_id')
            ->setParameter("product_id", $product_id)
            ->getQuery()
            ->getResult();
    }


}
