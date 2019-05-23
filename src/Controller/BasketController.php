<?php
/**
 * Created by PhpStorm.
 * User: Halyna_Mecherzhak
 * Date: 4/11/2019
 * Time: 12:32 PM
 */

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\BasketProduct;
use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\BasketProductRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class BasketController extends AbstractController
{
    /**
     * @Route("/basket" , name="basketList")
     *
     * @param BasketProductRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @param UserRepository $userRepository
     */
    public function index(BasketProductRepository $repository, UserRepository $userRepository)
    {
       $user = $this->get('security.token_storage')->getToken()->getUser();
       $userId = $this->getUser()->getId();

        if ($user)
        {
            $price = 0;
            array_map(function ($item) use (&$price)
            {
                $price += $item['price'];
                return $price;
            }, $repository->getBasketProductsListByUserId($userId));

            $data = $repository->getBasketProductsListByUserId($userId);
            array_push($data, "totalPrice", $price);
            //dd($data);
        }

        else
        {
            return new Response("<h1>User with such id doesn't exist!</h1>");
        }
        return $this->render('cart/cart.html.twig', array('data'=> $data));
    }

    /**
     * @Route("/cart/add/{productId}", name="shopping_basket")
     * @Method({"GET", "POST"})
     *
     * @param $productId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addProductToBasket($productId, BasketRepository $basketRepository)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $userId = $this->getUser()->getId();
        $existUserBasket =  $this->getDoctrine()->getRepository(Basket::class)->find($userId);
        $em = $this->getDoctrine()->getManager();

        if(!$existUserBasket)
        {
            $basket = new Basket();
            $basket->setUser($user);
            $em->persist($basket);
            $em->flush();
        }

        $basketId = $basketRepository->getBasketIdByUserId($userId);

        /** @var BasketProductRepository $basketProductRepo */
        $basketProductRepo = $this->getDoctrine()->getRepository(BasketProduct::class);
        $basketProduct = $basketProductRepo->findOneProductBasketOrCreateNewOne($basketId, $productId);
        $basketProduct->addQuantity();

        $em->persist($basketProduct);
        $em->flush();
        return  $this->redirectToRoute('basketList');
    }

    /**
     * @Route("/product/delete/{productId}", name="product_delete")
     *
     * @param $productId
     * @param BasketProductRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteProductFromBasket($productId, BasketProductRepository $repository)
    {
        $busketList = $repository->deleteProductFromBasketProduct($productId);
        return $this->redirectToRoute('cart_list');
    }

    /**
     * @Route("/emptyBasket")
     *
     * @param BasketProductRepository $repository
     * @param BasketRepository $basketRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAllProductsFromBasket(BasketProductRepository $repository, BasketRepository $basketRepository)
    {
        $busketList = $repository->deleteBasketProductList();
        $busketList = $basketRepository->deleteBasket();
        return $this->render('cart/cart.html.twig', array('busketList' => $busketList));
    }
}