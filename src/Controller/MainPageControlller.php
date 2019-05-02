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
        //var_dump($basket);

        $user = $basketRepository->getBasketUser();
        //var_dump($user);

        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        if (!$products) {
            throw $this->createNotFoundException(
                'No product found '
            );
        }
        return $this->render('products/products.html.twig', array('products' => $products));

    }

    /**
     * @Route("/user/{id}", requirements={"id":"\d+"})
     * @Method({"GET", "POST"})
     */
    public function getBasketProductsListByUserId($id, ProductRepository $productRepository, UserRepository $userRepository)
    {
        $user = $userRepository->getUserById($id);
        if ($user) {
            $busketList = $productRepository->getBasketProductsListByUserId($id);
            var_dump($busketList);
        } else {
            return new Response("<h1>User with such id doesn't exist!</h1>");

        }
        return new Response();
    }
}