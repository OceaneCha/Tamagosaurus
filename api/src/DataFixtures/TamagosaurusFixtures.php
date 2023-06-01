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

        $saurus = new Tamagosaurus();
        // $saurus->setType($type);
        $saurus->setName('John');
        $manager->persist($saurus);
        // $this->addReference('Tamagosaurus_' , $saurus);

        $manager->flush();
    }
}