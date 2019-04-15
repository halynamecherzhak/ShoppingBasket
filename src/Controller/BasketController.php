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
     * @Route("/product/delete/{product_id}", name="product_delete")
     */

    public function delete($product_id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository(Product::class)->find($product_id);

        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('cart_list');
    }

    /**
     * @Route("/cart/add/{product_id}", name="shopping_basket", requirements={"product_id":"\d+"})
     * @Method({"GET", "POST"})
     */
    public function addProductToBasket($product_id)
    {

        $basket = new Basket();
        $em = $this->getDoctrine()->getManager();
        $basket->setProductId($product_id);
        $em->persist($basket);
        $em->flush();

        return $this->redirectToRoute('cart_list');
    }
}