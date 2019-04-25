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

class BasketController extends Controller
{
    /**
     * @Route("/basket" , name="cart_list")
     */
    public function index(BasketProductRepository $repository)
    {
        $busketList = $repository->showBasketList();

        $totalprice = $repository->getTotalPrice();

        $data = json_encode($busketList,true);

        var_dump($data);
        var_dump($totalprice);

        return $this->render('cart/cart.html.twig', array('busketList' => $busketList));
    }

    /**
     * @Route("/cart/add/{basketId}/{productId}", name="shopping_basket",requirements={"basketId":"\d+"},requirements={"productId":"\d+"})
     * @Method({"GET", "POST"})
     *
     * @param $basketId
     * @param $productId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addProductToBasket($basketId, $productId)
    {
        /** @var BasketProductRepository $basketProductRepo */
        $basketProductRepo = $this->getDoctrine()->getRepository(BasketProduct::class);
        $basketProduct = $basketProductRepo->findOneOrCreate($basketId, $productId);

        var_dump($basketProduct);

        $basketProduct->addQuantity();

        $em = $this->getDoctrine()->getManager();
        $em->persist($basketProduct);
        $em->flush();

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
    public function deleteAllProductsFromBasket(BasketProductRepository $repository, BasketRepository $basketRepository)
    {
        $busketList = $repository->deleteBasketProductList();
        $busketList = $basketRepository->deleteBasket();
        return $this->render('cart/cart.html.twig', array('busketList' => $busketList));
    }

}