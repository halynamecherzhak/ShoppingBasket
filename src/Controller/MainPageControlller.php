<?php
/**
 * Created by PhpStorm.
 * User: Halyna_Mecherzhak
 * Date: 4/11/2019
 * Time: 12:32 PM
 */

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\BasketProductRepository;
use App\Repository\BasketRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainPageControlller extends Controller
{

    /**
     * @Route("/")
     * @Route("/products" , name="show products")
     */
    public function index(BasketProductRepository $basketProductRepository, BasketRepository $basketRepository)
    {
//        $basket= $basketProductRepository->getBasketProduct();
//        var_dump($basket);
//
//        $userpr = $basketRepository-> getBasketUser();
//        var_dump($userpr);


        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        if (!$products) {
            throw $this->createNotFoundException(
                'No product found '
            );
        }
        return $this->render('products/products.html.twig', array('products' => $products));

    }

    /**
     * @Route("/setUser")
     */
    public function setUser(){
        $user = new User();
        $user->setUserName('Pavlo');
        $user->setAddress('Medodvoi Pechery');
        $user->setEmail('pavlo_shostak@gmail.com');
        $user->setPhone('9325');

        $basket = new Basket();

        $basket->setUser($user);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->persist($basket);
        $entityManager->flush();
    }
}