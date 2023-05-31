<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app/stroll', name: 'app_stroll_')]
class StrollController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('stroll/index.html.twig', [
            'controller_name' => 'StrollController',
        ]);
    }

    #[Route('/{location}', name: 'go')]
    public function goTo(int $location): Response
    {
        $locations = [
            'parc',
            'plage',
        ];

        $destination = $locations[$location];

        return $this->render('stroll/show.html.twig', [
            'destination' => $destination,
        ]);
    }
}
