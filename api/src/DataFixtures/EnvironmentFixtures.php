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
            'image' => 'desert.png'
        ],
        [
            'name' => 'Mer',
            'image' => 'sea.png'
        ],
        [
            'name' => 'Ciel',
            'image' => 'sky.png'
        ],
        [
            'name' => 'Dimitri',
            'image' => 'cave.png'
        ],
        [
            'name' => '3D',
            'image' => '3d-paysage.png'
        ]
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::ENVIRONMENTS as $environment) {
            $newEnvironment = new Environment();
            $newEnvironment->setName($environment['name']);
            $newEnvironment->setImage('build/images/backgrounds/tamagosaurusWindow/' . $environment['image']);

            $manager->persist($newEnvironment);

            $this->addReference('environment_' . $environment['name'], $newEnvironment);
        }

        $manager->flush();
    }
}
