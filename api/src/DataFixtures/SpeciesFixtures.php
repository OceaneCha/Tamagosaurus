<?php

namespace App\DataFixtures;

use App\Entity\Species;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SpeciesFixtures extends Fixture implements DependentFixtureInterface
{
    public const SPECIES = [
        [
            'name' => 'Ichtyosaurus',
            'environment' => 'Mer',
        ],
        [
            'name' => 'Mosasaurus',
            'environment' => 'Mer',
        ],
        [
            'name' => 'Pteranodonus',
            'environment' => 'Ciel',
        ],
        [
            'name' => 'Quetzalcoatlus',
            'environment' => 'Ciel',
        ],
        [
            'name' => 'Tyranosaurus',
            'environment' => 'Terre',
        ],
        [
            'name' => 'Spinosaurus',
            'environment' => 'Terre',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SPECIES as $species) {
            $newSpecies = new Species();
            $newSpecies->setName($species['name']);
            
            $environment = $this->getReference('environment_' . $species['environment']);
            $newSpecies->setEnvironment($environment);
            $newSpecies->setImage('build/images/dinosaures/' . strtolower($species['name']) . '.png');

            $manager->persist($newSpecies);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            EnvironmentFixtures::class,
        ];
    }
}
