<?php

namespace App\DataFixtures;

use App\Entity\Egg;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EggFixtures extends Fixture implements DependentFixtureInterface
{
    public const EGGS = [
        0 => [
            'name' => 'Oeuf de la terre',
            'description' => '',
            'image' => 'egg-earth.png',
            'environment' => 'Terre',
        ],
        1 => [
            'name' => 'Oeuf de l\'air',
            'description' => '',
            'image' => 'egg-sky.png',
            'environment' => 'Ciel',
        ],
        2 => [
            'name' => 'Oeuf de la mer',
            'description' => '',
            'image' => 'egg-water.png',
            'environment' => 'Mer',
        ],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::EGGS as $egg) {
            $newEgg = new Egg();
            $newEgg->setName($egg['name']);
            $newEgg->setDescription($egg['description']);
            $newEgg->setImage('build/images/eggs/' . $egg['image']);

            $environment = $this->getReference('environment_' . $egg['environment']);
            $newEgg->setEnvironment($environment);

            $manager->persist($newEgg);
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
