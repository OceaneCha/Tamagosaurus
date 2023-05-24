<?php

namespace App\Controller;

use App\Entity\Tamagosaurus;
use App\Form\TamagosaurusType;
use App\Repository\TamagosaurusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app/tamagosaurus')]
class TamagosaurusController extends AbstractController
{
    #[Route('/', name: 'app_tamagosaurus_index', methods: ['GET'])]
    public function index(TamagosaurusRepository $tamagosaurusRepository): Response
    {
        return $this->render('tamagosaurus/index.html.twig', [
            'tamagosauruses' => $tamagosaurusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tamagosaurus_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TamagosaurusRepository $tamagosaurusRepository): Response
    {
        $tamagosauru = new Tamagosaurus();
        $form = $this->createForm(TamagosaurusType::class, $tamagosauru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tamagosaurusRepository->save($tamagosauru, true);

            return $this->redirectToRoute('app_tamagosaurus_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tamagosaurus/new.html.twig', [
            'tamagosauru' => $tamagosauru,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tamagosaurus_show', methods: ['GET'])]
    public function show(Tamagosaurus $tamagosauru): Response
    {
        return $this->render('tamagosaurus/show.html.twig', [
            'tamagosauru' => $tamagosauru,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tamagosaurus_edit', methods: ['GET', 'POST'])]
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

    #[Route('/{id}', name: 'app_tamagosaurus_delete', methods: ['POST'])]
    public function delete(Request $request, Tamagosaurus $tamagosauru, TamagosaurusRepository $tamagosaurusRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tamagosauru->getId(), $request->request->get('_token'))) {
            $tamagosaurusRepository->remove($tamagosauru, true);
        }

        return $this->redirectToRoute('app_tamagosaurus_index', [], Response::HTTP_SEE_OTHER);
    }
}