<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use App\Entity\Product;
use App\Entity\BasketProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BasketProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method BasketProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method BasketProduct[]    findAll()
 * @method BasketProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BasketProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BasketProduct::class);
    }

    public function  getBasketProduct(){
        return $this->createQueryBuilder('bp')
            ->select('bp.quantity, p.name')
            ->join(Product::class,'p')
            ->where('p.id = bp.product')
            ->getQuery()
            ->getResult();
    }

    public function showBasketList()
    {
        return $this->createQueryBuilder('bp')
            ->select('p.name,p.price')
            ->innerJoin(Product::class, 'p')
            ->where('p.id = bp.product')
            ->getQuery()
            ->getResult();
    }

    public function deleteProductFromBasketProduct($id)
    {
        return $this->createQueryBuilder('query')
            ->delete(BasketProduct::class,'b')
            ->where('b.product = :id')
            ->setParameter("id", $id)
            ->getQuery()
            ->getResult();
    }


}