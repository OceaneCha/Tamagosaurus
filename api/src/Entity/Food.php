<?php

namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodRepository::class)]
class Food
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $nutritionalvalue = null;

    #[ORM\Column(length: 255)]
    private ?string $Dinosaurpreferences = null;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNutritionalvalue(): ?int
    {
        return $this->nutritionalvalue;
    }

    public function setNutritionalvalue(int $nutritionalvalue): self
    {
        $this->nutritionalvalue = $nutritionalvalue;

        return $this;
    }

    public function getDinosaurpreferences(): ?string
    {
        return $this->Dinosaurpreferences;
    }

    public function setDinosaurpreferences(string $Dinosaurpreferences): self
    {
        $this->Dinosaurpreferences = $Dinosaurpreferences;

        return $this;
    }
}
