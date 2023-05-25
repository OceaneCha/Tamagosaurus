<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EnvironmentRepository;
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

    #[ORM\ManyToOne(inversedBy: 'environment')]
    private ?Species $species = null;

    #[ORM\Column(length: 255)]
    private ?string $TypeOfneed = null;

    #[ORM\Column]
    private ?int $LevelofSatisfaction = null;

    #[ORM\Column(length: 255)]
    private ?string $Priority = null;

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

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): self
    {
        $this->species = $species;

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
}
