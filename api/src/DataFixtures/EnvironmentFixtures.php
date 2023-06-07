<?php

namespace App\DataFixtures;

use App\Entity\Environment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EnvironmentFixtures extends Fixture
{
    public const ENVIRONMENTS = [
        [
            'name' => 'Terre',
        ],
        [
            'name' => 'Mer',
        ],
        [
            'name' => 'Ciel',
        ],
        [
            'name' => 'Dimitri',
        ],
        [
            'name' => '3D',
        ]
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::ENVIRONMENTS as $environment) {
            $newEnvironment = new Environment();
            $newEnvironment->setName($environment['name']);
            $newEnvironment->setImage('build/images/backgrounds/cave.png');

            $manager->persist($newEnvironment);

            $this->addReference('environment_' . $environment['name'], $newEnvironment);
        }

        $manager->flush();
    }
}
