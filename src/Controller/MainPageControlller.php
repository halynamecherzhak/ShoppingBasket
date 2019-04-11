<?php
/**
 * Created by PhpStorm.
 * User: Halyna_Mecherzhak
 * Date: 4/11/2019
 * Time: 12:32 PM
 */

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MainPageControlller extends  Controller{

    /**
     * @Route("/")
     * @Route("/products")
     */
    public function index(){

        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        if ( !$products )
        {
            throw $this->createNotFoundException(
                'No product found '
            );
        }
        return $this->render('products/products.html.twig', array('products' => $products));
    }

    /**
     * @Route("/cart")
     * @Method({"GET"})
     */
    public function show(){

        return $this->render('cart/cart.html.twig');

    }

}