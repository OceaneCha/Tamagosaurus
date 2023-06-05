<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SpeciesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpeciesRepository::class)]
#[ApiResource]
class Species
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Tamagosaurus::class)]
    private Collection $tamagosauruses;

    #[ORM\ManyToOne(inversedBy: 'species')]
    private ?Environment $environment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->tamagosauruses = new ArrayCollection();
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

    /**
     * @return Collection<int, Tamagosaurus>
     */
    public function getTamagosauruses(): Collection
    {
        return $this->tamagosauruses;
    }

    public function addTamagosaurus(Tamagosaurus $tamagosaurus): self
    {
        if (!$this->tamagosauruses->contains($tamagosaurus)) {
            $this->tamagosauruses->add($tamagosaurus);
            $tamagosaurus->setType($this);
        }

        return $this;
    }

    public function removeTamagosaurus(Tamagosaurus $tamagosaurus): self
    {
        if ($this->tamagosauruses->removeElement($tamagosaurus)) {
            // set the owning side to null (unless already changed)
            if ($tamagosaurus->getType() === $this) {
                $tamagosaurus->setType(null);
            }
        }

        return $this;
    }

    public function getEnvironment(): ?Environment
    {
        return $this->environment;
    }

    public function setEnvironment(?Environment $environment): self
    {
        $this->environment = $environment;

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
}
