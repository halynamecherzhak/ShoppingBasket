<?php

namespace App\Repository;

use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\BasketProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr\Join;

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

    public function getBasketList()
    {
        return $this->createQueryBuilder('bp')
            ->select('p.name,p.price,bp.quantity')
            ->innerJoin(Product::class, 'p')
            ->where('p.id = bp.product')
            ->getQuery()
            ->getResult();
    }

    public function deleteProductFromBasketProduct($productId)
    {
        return $this->createQueryBuilder('query')
            ->delete(BasketProduct::class, 'b')
            ->where('b.product = :productId')
            ->setParameter("productId", $productId)
            ->getQuery()
            ->getResult();
    }

    public function deleteBasketProductList()
    {
        return $this->createQueryBuilder('bp')
            ->delete(BasketProduct::class, 'bp')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $basketId
     * @param $productId
     * @return BasketProduct
     */
    public function findOneProductBasketOrCreateNewOne($basketId, $productId)
    {
        $existingProduct = $this->createQueryBuilder('bp')
            ->andWhere('bp.basket = :basketId')
            ->andWhere('bp.product = :productId')
            ->setParameter("basketId", $basketId)
            ->setParameter("productId", $productId)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$existingProduct)
        {
            $em = $this->getEntityManager();

            $basketProduct = new BasketProduct();

            $basket = $em->getReference(Basket::class, $basketId);
            $basketProduct->setBasket($basket);

            $product = $em->getReference(Product::class, $productId);
            $basketProduct->setProduct($product);

            $existingProduct = $basketProduct;
        }
        return $existingProduct;
    }

    public function  getBasketProductsListByUserId($userId)
    {
        return $this->createQueryBuilder('bp')
            ->select('p.name, p.price, bp.quantity')
            ->innerJoin(Product::class,'p',Join::WITH,'p.id = bp.product')
            ->innerJoin(Basket::class,'b',Join::WITH,'b.id = bp.basket')
            ->innerJoin(User::class,'u',Join::WITH,'u.id = b.user')
            ->where("u.id = :userId")
            ->setParameter("userId", $userId)
            ->getQuery()
            ->getResult();
    }
}