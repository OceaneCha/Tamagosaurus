<?php

namespace App\DataFixtures;

use App\Entity\Environment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EnvironmentFixtures extends Fixture
{
    public const ENVIRONMENTS = [
        0 => [
            'name' => 'Terre',
        ],
        1 => [
            'name' => 'Mer',
        ],
        2 => [
            'name' => 'Ciel',
        ]
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::ENVIRONMENTS as $environment) {
            $newEnvironment = new Environment();
            $newEnvironment->setName($environment['name']);

            $manager->persist($newEnvironment);

            $this->addReference('environment_' . $environment['name'], $newEnvironment);
        }

        $manager->flush();
    }
}
