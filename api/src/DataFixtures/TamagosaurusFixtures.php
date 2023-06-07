<?php

namespace App\DataFixtures;

use App\Entity\Species;
use App\Entity\Tamagosaurus;
use App\Repository\SpeciesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TamagosaurusFixtures extends Fixture implements DependentFixtureInterface
{   public function load(ObjectManager $manager): void
    {
        // No premade tamagosaurus

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}