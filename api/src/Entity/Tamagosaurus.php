<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use App\Controller\FeedingAction;
use App\Controller\GoingOutAction;
use App\Repository\TamagosaurusRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TamagosaurusRepository::class)]
#[ApiResource(
    mercure: true,
    operations: [
        new Get(),
        new Patch(
            controller: FeedingAction::class,
            uriTemplate: "/tamagosauruses/{id}/feed"
        ),
        new Patch(
            controller: GoingOutAction::class,
            uriTemplate: "/tamagosauruses/{id}/goingout"
        )
    ]
)]
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

    #[ORM\ManyToOne(inversedBy: 'tamagosauruses')]
    private ?User $owner = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastWentOut = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isAlive = null;



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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getLastWentOut(): ?\DateTimeInterface
    {
        return $this->lastWentOut;
    }

    public function setLastWentOut(?\DateTimeInterface $lastWentOut): self
    {
        $this->lastWentOut = $lastWentOut;

        return $this;
    }

    public function isIsAlive(): ?bool
    {
        return $this->isAlive;
    }

    public function setIsAlive(?bool $isAlive): self
    {
        $this->isAlive = $isAlive;

        return $this;
    }
}
