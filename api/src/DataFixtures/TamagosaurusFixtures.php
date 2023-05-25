<?php

namespace App\DataFixtures;

use App\Entity\Species;
use App\Entity\Tamagosaurus;
use App\Repository\SpeciesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TamagosaurusFixtures extends Fixture
{
    // public const TYPES = [
    //     'T-rex',
    //     'Type2',
    //     'Type3'
    // ];
    public function load(ObjectManager $manager): void
    {
        // foreach (self::TYPES as $type) {
        $saurus = new Tamagosaurus();
        $type = new Species();
        $type->setName('T-Rex');
        $saurus->setType($type);
        $saurus->setName('YY');
        $manager->persist($saurus);
        // $this->addReference('Tamagosaurus_1', $saurus);
        // }
        $manager->flush();
    }
}
