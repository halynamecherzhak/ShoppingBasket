<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="BasketProductRepository")
 */
class BasketProduct

{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private  $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="containProducts")
    */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Basket", inversedBy="containProducts")
     */
    private $basket;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return BasketProduct
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     * @return BasketProduct
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * @param mixed $basket
     * @return BasketProduct
     */
    public function setBasket($basket)
    {
        $this->basket = $basket;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     * @return BasketProduct
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }


}
