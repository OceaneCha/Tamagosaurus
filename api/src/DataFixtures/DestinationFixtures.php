<?php

namespace App\DataFixtures;

use App\Entity\Destination;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DestinationFixtures extends Fixture
{
    public const LOCATIONS = [
        0 => [
            'name' => 'Plage',
            'description' => 'à la plage',
            'image' => 'beach.jpg',
        ],
        1 => [
            'name' => 'Parc',
            'description' => 'au parc',
            'image' => 'park.jpg',
        ],
        2 => [
            'name' => 'Montagne',
            'description' => 'à la montagne',
            'image' => 'mountain.jpg',
        ],
        3 => [
            'name' => 'Ville',
            'description' => 'à la ville',
            'image' => 'city.jpg',
        ],
        4 => [
            'name' => 'Jungle',
            'description' => 'à la jungle',
            'image' => 'jungle.jpg',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::LOCATIONS as $location) {
            $destination = new Destination();
            $destination->setName($location['name']);
            $destination->setDescription($location['description']);
            $destination->setImage('build/images/backgrounds/' . $location['image']);
            $manager->persist($destination);
        }

        $manager->flush();
    }
}