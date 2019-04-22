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
use App\Entity\Product;
use App\Entity\User;
use App\Repository\BasketRepository;
use App\Repository\BasketProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BasketController extends Controller
{
    /**
     * @Route("/basket" , name="cart_list")
     */
    public function index(BasketProductRepository $repository)
    {
        $busketList = $repository->showBasketList();

        var_dump($busketList);

        return $this->render('cart/cart.html.twig', array('busketList' => $busketList));
    }

    /**
     * @Route("/cart/add/{id}", name="shopping_basket", requirements={"id":"\d+"})
     * @Method({"GET", "POST"})
     */
    public function addProductToBasket($id)
    {
        $user = new User();
        $user->setUserName('Lida');
        $user->setAddress('Medodvoi Pechery');
        $user->setEmail('lida_shostak@gmail.com');
        $user->setPhone('1596');

        $basket = new Basket();
        $basket->setUser($user);

        $basketProduct = new BasketProduct();

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        $basketProduct->setBasket($basket);
        $basketProduct->setQuantity(8);
        $basketProduct->setProduct($product);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->persist($basket);
        $entityManager->persist($basketProduct);
        $entityManager->flush();

        return $this->redirectToRoute('cart_list');
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete")
     */

    public function delete($id, BasketProductRepository $repository)
    {
        $busketList = $repository->deleteProductFromBasketProduct($id);

        return $this->redirectToRoute('cart_list');

    }

    /**
     * @Route("/emptyBasket")
     */
    public function deleteAllProductsFromBasket(BasketProductRepository $repository){
        $busketList = $repository->deleteBasketProductList();
        return $this->render('cart/cart.html.twig', array('busketList' => $busketList));
    }


}