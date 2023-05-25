<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tamagosaurus;

#[Route('/app', name: 'app_')]
class DefaultController extends AbstractController
{
    #[Route('/default', name: 'default')]
    public function index(): Response
    {
        $saurus = new Tamagosaurus(5);
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
