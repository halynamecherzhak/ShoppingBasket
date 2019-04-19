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
use App\Repository\BasketRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class BasketController extends Controller
{
    /**
     * @Route("/basket" , name="cart_list")
     */
    public function index(BasketRepository $repository)
    {
        $busketList = $repository->showBasketList();

        return $this->render('cart/cart.html.twig', array('busketList' => $busketList));
    }


    /**
     * @Route("/product/delete/{id}", name="product_delete")
     */

    public function delete($id,BasketRepository $repository)
    {

        $busketList = $repository->deleteProductFromBasket($id);

        return $this->redirectToRoute('cart_list');

    }

    /**
     * @Route("/emptyBasket")
     */

    public function deleteAllProductsFromBasket(BasketRepository $repository){

        $busketList = $repository->deleteBasketList();

        return $this->render('cart/cart.html.twig', array('busketList' => $busketList));

    }

    /**
     * @Route("/cart/add/{id}", name="shopping_basket", requirements={"id":"\d+"})
     * @Method({"GET", "POST"})
     */
    public function addProductToBasket($id)
    {

        $basket = new Basket();
        $em = $this->getDoctrine()->getManager();
        $basket->setProductId($id);
        $em->persist($basket);
        $em->flush();

        return $this->redirectToRoute('cart_list');
    }
}