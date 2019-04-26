<?php

namespace App\Repository;


use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\BasketProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;


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

    public function getTotalPrice()
    {
        $totalprice = $this->createQueryBuilder('bp')
            ->select('SUM(p.price) as totalprice')
            ->join(Product::class, 'p')
            ->where('p.id = bp.product')
            ->getQuery()
            ->getSingleResult();
        return $totalprice;

    }

    public function getBasketProduct()
    {
        return $this->createQueryBuilder('bp')
            ->select('bp.quantity, p.name')
            ->join(Product::class, 'p')
            ->where('p.id = bp.product')
            ->getQuery()
            ->getResult();

    }

    public function showBasketList()
    {
        return $this->createQueryBuilder('bp')
            ->select('p.name,p.price,bp.quantity')
            ->innerJoin(Product::class, 'p')
            ->where('p.id = bp.product')
            ->getQuery()
            ->getResult();
    }

    public function deleteProductFromBasketProduct($id)
    {
        return $this->createQueryBuilder('query')
            ->delete(BasketProduct::class, 'b')
            ->where('b.product = :id')
            ->setParameter("id", $id)
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

    public function findOneOrCreate($basketId, $productId)
    {
        $existingProduct = $this->createQueryBuilder('bp')
            ->andWhere('bp.basket = :basketId')
            ->andWhere('bp.product = :productId')
            ->setParameter("basketId", $basketId)
            ->setParameter("productId", $productId)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$existingProduct) {
            $em = $this->getEntityManager();
            // create BP
            $basketProduct = new BasketProduct();

            $item = $em->getReference(Basket::class, $basketId);
            $basketProduct->setBasket($item);

            $item2 = $em->getReference(Product::class, $productId);
            $basketProduct->setProduct($item2);

            return $basketProduct;
        }
        return $existingProduct;
    }
}