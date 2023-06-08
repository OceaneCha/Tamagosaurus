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
            'foodInterval' => '20',
        ],
        [
            'name' => 'Mosasaurus',
            'environment' => 'Mer',
            'foodInterval' => '20',
        ],
        [
            'name' => 'Plesiosorus',
            'environment' => 'Mer',
            'foodInterval' => '20',
        ],
        [
            'name' => 'Pteranodonus',
            'environment' => 'Ciel',
            'foodInterval' => '20',
        ],
        [
            'name' => 'Archaeopteryxus',
            'environment' => 'Ciel',
            'foodInterval' => '20',
        ],
        [
            'name' => 'Quetzalcoatlus',
            'environment' => 'Terre',
            'foodInterval' => '20',
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
        [
            'name' => 'Diplodocus',
            'environment' => 'Terre',
            'foodInterval' => '20',
        ],
        [
            'name' => 'Dimitrus',
            'environment' => 'Dimitri',
            'foodInterval' => '20',
        ],
        [
            'name' => '3DSaurus',
            'environment' => '3D',
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
            $seconds = new \DateInterval('PT' . $species['foodInterval'] . 'S');
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
