<?php

namespace App\Controller;
use App\Service\TamagosaurusService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Tamagosaurus;

class StatusAction extends AbstractController
{
    /** @param Tamagosaurus */
    public function __invoke($data, TamagosaurusService $tamagosaurusService)
    {
        $tamagosaurusService->checkStatus($data);

        return $data;
    }
}