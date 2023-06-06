<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EnvironmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnvironmentRepository::class)]
#[ApiResource]
class Environment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $TypeOfneed = null;

    #[ORM\Column(nullable: true)]
    private ?int $LevelofSatisfaction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Priority = null;

    #[ORM\OneToMany(mappedBy: 'environment', targetEntity: Egg::class)]
    private Collection $eggs;

    #[ORM\OneToMany(mappedBy: 'environment', targetEntity: Species::class)]
    private Collection $species;

    public function __construct()
    {
        $this->eggs = new ArrayCollection();
        $this->species = new ArrayCollection();
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

    public function getTypeOfneed(): ?string
    {
        return $this->TypeOfneed;
    }

    public function setTypeOfneed(string $TypeOfneed): self
    {
        $this->TypeOfneed = $TypeOfneed;

        return $this;
    }

    public function getLevelofSatisfaction(): ?int
    {
        return $this->LevelofSatisfaction;
    }

    public function setLevelofSatisfaction(int $LevelofSatisfaction): self
    {
        $this->LevelofSatisfaction = $LevelofSatisfaction;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->Priority;
    }

    public function setPriority(string $Priority): self
    {
        $this->Priority = $Priority;

        return $this;
    }

    /**
     * @return Collection<int, Egg>
     */
    public function getEggs(): Collection
    {
        return $this->eggs;
    }

    public function addEgg(Egg $egg): self
    {
        if (!$this->eggs->contains($egg)) {
            $this->eggs->add($egg);
            $egg->setEnvironment($this);
        }

        return $this;
    }

    public function removeEgg(Egg $egg): self
    {
        if ($this->eggs->removeElement($egg)) {
            // set the owning side to null (unless already changed)
            if ($egg->getEnvironment() === $this) {
                $egg->setEnvironment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Species>
     */
    public function getSpecies(): Collection
    {
        return $this->species;
    }

    public function addSpecies(Species $species): self
    {
        if (!$this->species->contains($species)) {
            $this->species->add($species);
            $species->setEnvironment($this);
        }

        return $this;
    }

    public function removeSpecies(Species $species): self
    {
        if ($this->species->removeElement($species)) {
            // set the owning side to null (unless already changed)
            if ($species->getEnvironment() === $this) {
                $species->setEnvironment(null);
            }
        }

        return $this;
    }
}
