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

    #[ORM\OneToMany(mappedBy: 'species', targetEntity: Environment::class)]
    private Collection $environment;

    public function __construct()
    {
        $this->environment = new ArrayCollection();
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
     * @return Collection<int, Environment>
     */
    public function getEnvironment(): Collection
    {
        return $this->environment;
    }

    public function addEnvironment(Environment $environment): self
    {
        if (!$this->environment->contains($environment)) {
            $this->environment->add($environment);
            $environment->setSpecies($this);
        }

        return $this;
    }

    public function removeEnvironment(Environment $environment): self
    {
        if ($this->environment->removeElement($environment)) {
            // set the owning side to null (unless already changed)
            if ($environment->getSpecies() === $this) {
                $environment->setSpecies(null);
            }
        }

        return $this;
    }
}
