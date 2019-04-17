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

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainPageControlller extends Controller
{

    /**
     * @Route("/")
     * @Route("/products" , name="show products")
     */
    public function index(ProductRepository $repository)
    {

        //$products = $repository->showProductsList();

        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        if (!$products) {
            throw $this->createNotFoundException(
                'No product found '
            );
        }

        return $this->render('products/products.html.twig', array('products' => $products));
    }

}