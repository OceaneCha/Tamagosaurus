<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TamagosaurusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TamagosaurusRepository::class)]
#[ApiResource(mercure: true)]
class Tamagosaurus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $hunger = 10;

    public function __construct(int $hunger)
    {
        $this->hunger = $hunger;    
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHunger(): ?int
    {
        return $this->hunger;
    }

    public function setHunger(int $hunger): self
    {
        $this->hunger = $hunger;

        return $this;
    }
}
