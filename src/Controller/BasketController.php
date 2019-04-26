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
     *
     * @param BasketProductRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(BasketProductRepository $repository)
    {
        $price=0;
        array_map(function ($item) use(&$price)
        {
            $price += $item['price'];
            return $price;
        }, $repository->getBasketList());

        $data = $repository->getBasketList();
        array_push($data,"totalPrice",$price );

        print_r($data);

        return $this->render('cart/cart.html.twig', array('busketList' => $data, 'price' => $price));
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

        $basketProduct->addQuantity();

        $em = $this->getDoctrine()->getManager();
        $em->persist($basketProduct);
        $em->flush();

        return $this->redirectToRoute('cart_list');
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete")
     *
     * @param $id
     * @param BasketProductRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete($id, BasketProductRepository $repository)
    {
        $busketList = $repository->deleteProductFromBasketProduct($id);

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