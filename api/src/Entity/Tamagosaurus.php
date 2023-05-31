<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TamagosaurusRepository;
use Doctrine\DBAL\Types\Types;
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
    private ?int $hunger = 5;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'tamagosauruses', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Species $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastFed = null;



    public function __construct()
    {
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?Species
    {
        return $this->type;
    }

    public function setType(?Species $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLastFed(): ?\DateTimeInterface
    {
        return $this->lastFed;
    }

    public function setLastFed(?\DateTimeInterface $lastFed): self
    {
        $this->lastFed = $lastFed;

        return $this;
    }
}
