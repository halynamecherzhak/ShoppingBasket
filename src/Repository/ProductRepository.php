<?php

namespace App\Repository;

use App\Entity\Basket;
use App\Entity\BasketProduct;
use App\Entity\User;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getProducts(){
        return $this->createQueryBuilder('p')
            ->select(['p.name','c.name'])
            ->innerJoin(Category::class,'c',Join::WITH,'p.id = c.products')
            ->getQuery()
            ->getResult();
    }
}
