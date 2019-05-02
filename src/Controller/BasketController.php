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
use Symfony\Component\HttpFoundation\Response;
use App\Repository\BasketProductRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BasketController extends Controller
{
    /**
     * @Route("/basket/{userId}" , name="cart_list")
     *
     * @param BasketProductRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @param $userId
     * @param UserRepository $userRepository
     */
    public function index($userId, BasketProductRepository $repository, UserRepository $userRepository)
    {
        $user = $userRepository->getUserById($userId);
        if ($user) {

            $price = 0;
            array_map(function ($item) use (&$price) {
                $price += $item['price'];
                return $price;
            }, $repository->getBasketProductsListByUserId($userId));

            $data = $repository->getBasketProductsListByUserId($userId);
            array_push($data, "totalPrice", $price);

            print_r($data);
        } else {
            return new Response("<h1>User with such id doesn't exist!</h1>");
        }

        return $this->render('cart/cart.html.twig', array('busketList' => $data, 'price' => $price));
    }

    /**
     * @Route("/cart/add/{basketId}/{productId}/{userId}", name="shopping_basket")
     * @Method({"GET", "POST"})
     *
     * @param $basketId
     * @param $productId
     * @param $userId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addProductToBasket($basketId, $productId, $userId, UserRepository $userRepository)
    {
        $user = $userRepository->getUserById($userId);
        if ($user) {

            /** @var BasketProductRepository $basketProductRepo */
            $basketProductRepo = $this->getDoctrine()->getRepository(BasketProduct::class);

            $basketProduct = $basketProductRepo->findOneOrCreate($basketId, $productId);

            $basketProduct->addQuantity();

            $em = $this->getDoctrine()->getManager();
            $em->persist($basketProduct);
            $em->flush();

            return $this->redirectToRoute('cart_list/{userId}');
        } else {

            return new Response("<h1>User with such id doesn't exist!</h1>");
        }
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