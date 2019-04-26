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
use App\Repository\BasketProductRepository;
use App\Repository\BasketRepository;
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
        $basket = $basketProductRepository->getBasketProduct();
        var_dump($basket);

        $user = $basketRepository->getBasketUser();
        var_dump($user);


        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        if (!$products) {
            throw $this->createNotFoundException(
                'No product found '
            );
        }
        return $this->render('products/products.html.twig', array('products' => $products));

    }

    /**
     * @Route("/user/{id}", name="get_user", requirements={"id":"\d+"})
     * @Method({"GET", "POST"})
     */
    public function getBasketByUserId($id, BasketProductRepository $basketProductRepository)
    {
        #$user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $user_basket = $this->getDoctrine()
            ->getRepository(Basket::class)
            ->find($id);

        if ($user_basket) {

            //show busket for user{id}
            $busketList = $basketProductRepository->showBasketList();
            var_dump($busketList);

        } else {
            $basket = new Basket();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($basket);
            $entityManager->flush();

            return $this->redirectToRoute('cart_list');
        }
        return new Response();
    }
}