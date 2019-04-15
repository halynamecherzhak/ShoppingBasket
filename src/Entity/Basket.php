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

    /**
     * @ORM\Column(type="integer")
     */
    private $product_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    private $containProducts;
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
