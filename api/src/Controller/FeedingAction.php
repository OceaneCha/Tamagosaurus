<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Tamagosaurus;

class FeedingAction extends AbstractController
{
    /** @param Tamagosaurus */
    public function __invoke($data)
    {
        $data->setLastFed(new \DateTime());

        return $data;
    }
}