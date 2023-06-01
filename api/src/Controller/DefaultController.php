<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tamagosaurus;
use App\Repository\DestinationRepository;

#[Route('/app', name: 'app_')]
class DefaultController extends AbstractController
{
    #[Route('/default', name: 'default')]
    public function index(DestinationRepository $destinationRepository): Response
    {
        $destinations = $destinationRepository->findAll();

        $saurus = new Tamagosaurus(5);
        $saurus->setName("Diplosaure Aquaticus");
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController', 
            'tamagosauru' => $saurus,
            'destinations' => $destinations,
        ]);
    }
}