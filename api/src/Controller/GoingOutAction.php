<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Tamagosaurus;

class GoingOutAction extends AbstractController
{
    /** @param Tamagosaurus */
    public function __invoke($data)
    {
        $data->setLastWentOut(new \DateTime());

        return $data;
    }
}