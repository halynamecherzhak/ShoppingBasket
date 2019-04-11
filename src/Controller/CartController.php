<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/11/2019
 * Time: 11:58 PM
 */

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CartController extends Controller{

    /**
     * @Route("/cart/addTo/{product_id}", name="add_to_cart")
     */
    public function addAction($product_id)
    {
        $em = $this->getDoctrine()->getManager();
        # for any case wewill need to select product so select it first
        # select specific product which have passed id using ['find(passedID)']
        $product = $this->getDoctrine()
            ->getRepository('Product')
            ->find($product_id);

            # defince cart object
            #$cart = new Cart();
            # set user whose own this cart
            #$cart->setUser($user);

            # set initail total price for cart which equal to product price
            #$cart->setTotalPrice($product->getPrice());
            # persist all cart data to can use it in create shipping object
            #$em->persist($cart);
            # flush it
            #$em->flush();
            # create shipping object
            $ship = new Order();
            # set all its data quantity initail equal to 1 and passed product and cart created
            $ship->setQuantity(1);
            $ship->setProduct($product);
            #$ship->setCart($cart);
            # persist it and flush doctrine to save it
            $em->persist($ship);
            $em->flush();

        return $this->redirect($this->generateUrl('show products'));
    }
}