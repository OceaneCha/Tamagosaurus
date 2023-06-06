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
            'foodInterval' => '30',
        ],
        [
            'name' => 'Mosasaurus',
            'environment' => 'Mer',
            'foodInterval' => '20',
        ],
        [
            'name' => 'Pteranodonus',
            'environment' => 'Ciel',
            'foodInterval' => '60',
        ],
        [
            'name' => 'Quetzalcoatlus',
            'environment' => 'Ciel',
            'foodInterval' => '45',
        ],
        [
            'name' => 'Tyranosaurus',
            'environment' => 'Terre',
            'foodInterval' => '20',
        ],
        [
            'name' => 'Spinosaurus',
            'environment' => 'Terre',
            'foodInterval' => '20',
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
            $seconds = new \DateInterval('PT360S');
            $newSpecies->setFoodInterval($seconds);

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
