<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BasketRepository")
 */
class Basket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="basket")
     */
    private $user;


    /** @ORM\OneToMany(targetEntity="BasketProduct", mappedBy="basket")
     */
    private $basketProducts;

//    /**
//     * Basket constructor.
//     * @param $basketProducts
//     */
//    public function __construct($basketProducts)
//    {
//        $this->basketProducts = $basketProducts;
//    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Basket
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getBasketProducts()
    {
        return $this->basketProducts;
    }

    /**
     * @param mixed $basketProducts
     * @return Basket
     */
    public function setBasketProducts($basketProducts)
    {
        $this->basketProducts = $basketProducts;
        return $this;
    }
}
