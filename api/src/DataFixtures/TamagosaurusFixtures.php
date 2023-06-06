<?php

namespace App\DataFixtures;

use App\Entity\Species;
use App\Entity\Tamagosaurus;
use App\Repository\SpeciesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TamagosaurusFixtures extends Fixture implements DependentFixtureInterface
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
        $saurus->setOwner($this->getReference('admin_user'));
        $saurus->setImage('/build/images/dinosaures/ichtyosaurus.png');
        $manager->persist($saurus);
        // $this->addReference('Tamagosaurus_' , $saurus);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}