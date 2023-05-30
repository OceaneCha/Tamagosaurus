<?php

namespace App\Controller;

use App\Entity\Tamagosaurus;
use App\Form\TamagosaurusType;
use App\Repository\TamagosaurusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app/tamagosaurus', name: 'app_tamagosaurus_')]
class TamagosaurusController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(TamagosaurusRepository $tamagosaurusRepository): Response
    {
        // Modify render template later
        return $this->render('default/index.html.twig', [
            'tamagosauruses' => $tamagosaurusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, TamagosaurusRepository $tamagosaurusRepository): Response
    {
        $tamagosauru = new Tamagosaurus();
        $form = $this->createForm(TamagosaurusType::class, $tamagosauru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Avant de sauvegarder le tamagosaurus, inject its type
            // En fonction de l'oeuf sélectionné par l'utilisateur
            //
            // $tamagosauru->setType($type);
            //
            // OU
            // Utiliser les méthodes d'API-Platform (POST) plutôt que le formulaire
            $tamagosaurusRepository->save($tamagosauru, true);

            $this->addFlash('success', 'The tamagosaurus has been named!');

            return $this->redirectToRoute('app_tamagosaurus_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tamagosaurus/_form.html.twig', [
            'tamagosauru' => $tamagosauru,
            'form' => $form,
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
