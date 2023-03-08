<?php

namespace App\Controller;

use App\Entity\Objetos;
use App\Form\ObjetosType;
use App\Repository\ObjetosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/objetos')]
class ObjetosController extends AbstractController
{
    #[Route('/', name: 'app_objetos_index', methods: ['GET'])]
    public function index(ObjetosRepository $objetosRepository): Response
    {
        return $this->render('objetos/index.html.twig', [
            'objetos' => $objetosRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_objetos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ObjetosRepository $objetosRepository): Response
    {
        $objeto = new Objetos();
        $form = $this->createForm(ObjetosType::class, $objeto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objetosRepository->save($objeto, true);

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('objetos/new.html.twig', [
            'objeto' => $objeto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objetos_show', methods: ['GET'])]
    public function show(Objetos $objeto): Response
    {
        return $this->render('objetos/show.html.twig', [
            'objeto' => $objeto,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_objetos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Objetos $objeto, ObjetosRepository $objetosRepository): Response
    {
        $form = $this->createForm(ObjetosType::class, $objeto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objetosRepository->save($objeto, true);

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('objetos/edit.html.twig', [
            'objeto' => $objeto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objetos_delete', methods: ['POST'])]
    public function delete(Request $request, Objetos $objeto, ObjetosRepository $objetosRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$objeto->getId(), $request->request->get('_token'))) {
            $objetosRepository->remove($objeto, true);
        }

        return $this->redirectToRoute('app_objetos_index', [], Response::HTTP_SEE_OTHER);
    }
}
