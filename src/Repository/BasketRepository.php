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

    public function getBasketUser()
    {
        return $this->createQueryBuilder('b')
            ->select(['b.id', 'u.userName'])
            ->innerJoin(User::class, 'u', Join::WITH, 'u.id = b.user')
            ->getQuery()
            ->getResult();
    }

    public function deleteBasket()
    {
        return $this->createQueryBuilder('b')
            ->delete(Basket::class, 'b')
            ->getQuery()
            ->getResult();
    }


    /**
     * @Route("/user/{id}", name="get_user", requirements={"id":"\d+"})
     * @Method({"GET", "POST"})
     */
    public function getBasketByUserId($id, BasketProductRepository $basketProductRepository)
    {
        // $user= $basketRepository->getUserById($id);
        // $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $user_basket = $this->getDoctrine()
            ->getRepository(Basket::class)
            ->find($id);

        if ($user_basket) {
            //show busket for user{id}
            $busketList = $basketProductRepository->getBasketList();
            var_dump($busketList);

        }
        return new Response();
    }

}
