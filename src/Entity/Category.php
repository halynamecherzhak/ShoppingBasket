<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $category_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category_name;

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
