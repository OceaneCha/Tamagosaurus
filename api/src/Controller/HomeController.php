<?php

namespace App\Controller;

use App\Repository\EggRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/app', name: 'app_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/egg', name: 'egg')]
    #[IsGranted('ROLE_USER')]
    public function eggChoice(EggRepository $eggRepository): Response
    {
        return $this->render('home/eggChoice.html.twig', [
            'eggs' => $eggRepository->findAll(),
        ]);
    }

    #[Route('/birth', name: 'birth')]
    #[IsGranted('ROLE_USER')]
    public function dinoBirth(): Response
    {
        return $this->render('home/birth.html.twig');
    }
}
