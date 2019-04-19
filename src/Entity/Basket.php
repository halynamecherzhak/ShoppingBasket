<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    private $containProducts;

    /**
     * @return ArrayCollection
     */
    public function getContainProducts(): ArrayCollection
    {
        return $this->containProducts;
    }

    /**
     * @param ArrayCollection $containProducts
     * @return Basket
     */
    public function setContainProducts(ArrayCollection $containProducts): Basket
    {
        $this->containProducts = $containProducts;
        return $this;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->containProducts = new ArrayCollection();
    }

    /**
     * Set containProducts
     *
     * @param Product $containProducts
     *
     * @return Basket
     */
    public function addProduct(Product $containProducts)
    {
        $this->containProducts->add($containProducts);
        return $this;
    }


}
