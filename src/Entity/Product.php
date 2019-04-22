<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $price;

    /** @ORM\OneToMany(targetEntity="BasketProduct", mappedBy="product") */
    protected $basketProducts;

//    /**
//     * Product constructor.
//     * @param $basketProducts
//     */
//    public function __construct($basketProducts)
//    {
//        $this->basketProducts = $basketProducts;
//    }

    /**
     * @return mixed
     */
    public function getBasketProducts()
    {
        return $this->basketProducts;
    }

    /**
     * @param mixed $basketProducts
     * @return Product
     */
    public function setBasketProducts($basketProducts)
    {
        $this->basketProducts = $basketProducts;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
