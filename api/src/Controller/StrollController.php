<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Repository\DestinationRepository;
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

#[Route('/{destination}', name: 'go')]
    public function goTo(Destination $destination, DestinationRepository $destinationRepository): Response
    {
        // $locations = [
        //     'au parc',
        //     'à la plage',
        //     'à la montagne',
        //     'en ville',
        //     'dans la jungle',
        // ];

        // $destination = $locations[$location];

        return $this->render('stroll/show.html.twig', [
            'destination' => $destination,
        ]);
    }

}