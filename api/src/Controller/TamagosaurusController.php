<?php

namespace App\Controller;

use App\Entity\Tamagosaurus;
use App\Entity\Egg;
use App\Form\TamagosaurusType;
use App\Repository\DestinationRepository;
use App\Repository\SpeciesRepository;
use App\Repository\TamagosaurusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/app/tamagosaurus', name: 'app_tamagosaurus_')]
class TamagosaurusController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(TamagosaurusRepository $tamagosaurusRepository, DestinationRepository $destinationRepository): Response
    {        
        if (!$this->getUser()->getTamagosauruses()->count()) {
            return $this->redirectToRoute('app_egg');
        }
        
        return $this->render('tamagosaurus/index.html.twig', [
            'tamagosauru' => $this->getUser()->getTamagosauruses()->first(),
            'destinations' => $destinationRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'new', methods: ['GET', 'POST'])]
    public function new(Egg $egg, Request $request, TamagosaurusRepository $tamagosaurusRepository, SpeciesRepository $speciesRepository): Response
    {
        $session = $request->getSession();
        $tamagosaurus = new Tamagosaurus();
        $form = $this->createForm(TamagosaurusType::class, $tamagosaurus);
        $form->handleRequest($request);
        
        $environment = $egg->getEnvironment();
        $allSpecies = $environment->getSpecies()->toArray();

        if (!$form->isSubmitted()) {
            $session->remove('newSaurus');
        }

        if (!$session->get('newSaurus')) {
            $species = $allSpecies[array_rand($allSpecies)];
            $session->set('newSaurus', $species->getName());
        }

        if ($form->isSubmitted() && $form->isValid()) {
            
            $tamagosaurus->setOwner($this->getUser());
            $species = $speciesRepository->findOneBy(['name' => $session->get('newSaurus')]);
            $tamagosaurus->setType($species);
            $tamagosaurus->setImage($species->getImage());

            $tamagosaurusRepository->save($tamagosaurus, true);

            $this->addFlash('success', 'Welcome among us, ' . $tamagosaurus->getName() . ' !');
            $session->remove('newSaurus');

            return $this->redirectToRoute('app_tamagosaurus_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tamagosaurus/new.html.twig', [
            'tamagosauru' => $tamagosaurus,
            'form' => $form,
            'species' => $species,
            'egg' => $egg,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Tamagosaurus $tamagosauru): Response
    {
        return $this->render('tamagosaurus/show.html.twig', [
            'tamagosauru' => $tamagosauru,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tamagosaurus $tamagosauru, TamagosaurusRepository $tamagosaurusRepository): Response
    {
        $form = $this->createForm(TamagosaurusType::class, $tamagosauru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tamagosaurusRepository->save($tamagosauru, true);

            return $this->redirectToRoute('app_tamagosaurus_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tamagosaurus/edit.html.twig', [
            'tamagosauru' => $tamagosauru,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Tamagosaurus $tamagosauru, TamagosaurusRepository $tamagosaurusRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tamagosauru->getId(), $request->request->get('_token'))) {
            $tamagosaurusRepository->remove($tamagosauru, true);
        }

        return $this->redirectToRoute('app_tamagosaurus_index', [], Response::HTTP_SEE_OTHER);
    }
}