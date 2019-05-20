<?php
/**
 * Created by PhpStorm.
 * User: Halyna_Mecherzhak
 * Date: 4/11/2019
 * Time: 12:32 PM
 */

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function showAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/products" , name="show products")
     * @return Response
     */
    public function index()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        if (!$products)
        {
            throw $this->createNotFoundException(
                'No product found '
            );
        }
        return $this->render('products/products.html.twig', array('products' => $products));

    }
}