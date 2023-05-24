<?php

namespace App\DataFixtures;

use App\Entity\Tamagosaurus;
use App\Repository\SpeciesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TamagosaurusFixtures extends Fixture
{
    public const TYPES = [
        'T-rex',
        'Type2',
        'Type3'
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::TYPES as $type) {
            $saurus = new Tamagosaurus();
            $saurus->setType($type);
            $manager->persist($saurus);
            $this->addReference('Tamagosaurus_' . $type, $saurus);
        }
        $manager->flush();
    }
}
