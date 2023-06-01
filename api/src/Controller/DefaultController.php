<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tamagosaurus;
use App\Repository\DestinationRepository;
use App\Repository\TamagosaurusRepository;

#[Route('/app', name: 'app_')]
class DefaultController extends AbstractController
{
    #[Route('/default', name: 'default')]
    public function index(DestinationRepository $destinationRepository, TamagosaurusRepository $tamagosaurusRepository): Response
    {
        $destinations = $destinationRepository->findAll();
        if (
            $this->isGranted('ROLE_USER')
        ) {
            $user = $this->getUser();
            $sauruses = $user->getTamagosauruses();
            $saurus = $sauruses->first();
        } else {
            $saurus = new Tamagosaurus;
            $saurus->setName("Diplosaure Aquaticus");
        }
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'tamagosauru' => $saurus,
            'destinations' => $destinations,
        ]);
    }
}
