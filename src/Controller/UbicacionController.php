<?php

namespace App\Controller;

use App\Entity\Ubicacion;
use App\Form\UbicacionType;
use App\Repository\UbicacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ubicacion')]
class UbicacionController extends AbstractController
{
    #[Route('/', name: 'app_ubicacion_index', methods: ['GET'])]
    public function index(UbicacionRepository $ubicacionRepository): Response
    {
        return $this->render('ubicacion/index.html.twig', [
            'ubicacions' => $ubicacionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ubicacion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UbicacionRepository $ubicacionRepository): Response
    {
        $ubicacion = new Ubicacion();
        $form = $this->createForm(UbicacionType::class, $ubicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ubicacionRepository->save($ubicacion, true);

            return $this->redirectToRoute('app_ubicacion_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ubicacion/new.html.twig', [
            'ubicacion' => $ubicacion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ubicacion_show', methods: ['GET'])]
    public function show(Ubicacion $ubicacion): Response
    {
        return $this->render('ubicacion/show.html.twig', [
            'ubicacion' => $ubicacion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ubicacion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ubicacion $ubicacion, UbicacionRepository $ubicacionRepository): Response
    {
        $form = $this->createForm(UbicacionType::class, $ubicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ubicacionRepository->save($ubicacion, true);

            return $this->redirectToRoute('app_ubicacion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ubicacion/edit.html.twig', [
            'ubicacion' => $ubicacion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ubicacion_delete', methods: ['POST'])]
    public function delete(Request $request, Ubicacion $ubicacion, UbicacionRepository $ubicacionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ubicacion->getId(), $request->request->get('_token'))) {
            $ubicacionRepository->remove($ubicacion, true);
        }

        return $this->redirectToRoute('app_ubicacion_index', [], Response::HTTP_SEE_OTHER);
    }
}
