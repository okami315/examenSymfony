<?php

namespace App\Controller;

use DateTime;
use App\Entity\Entradas;
use App\Entity\Objetos;
use App\Form\EntradasType;
use App\Repository\EntradasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/entradas')]
class EntradasController extends AbstractController
{
    #[Route('/', name: 'app_entradas_index', methods: ['GET'])]
    public function index(EntradasRepository $entradasRepository): Response
    {
        return $this->render('entradas/index.html.twig', [
            'entradas' => $entradasRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_entradas_new', methods: ['GET', 'POST'])]
    public function new(Objetos $objeto,Request $request, EntradasRepository $entradasRepository): Response
    {
        $entrada = new Entradas();
        $form = $this->createForm(EntradasType::class, $entrada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($objeto->getQuantity()){

            }
            $entrada->setObjetos($objeto);
            $entrada->setDate(new DateTime());
            $entradasRepository->save($entrada, true);

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entradas/new.html.twig', [
            'entrada' => $entrada,
            'form' => $form,
            'objeto' => $objeto,
        ]);
    }

    #[Route('/{id}', name: 'app_entradas_show', methods: ['GET'])]
    public function show(Entradas $entrada): Response
    {
        return $this->render('entradas/show.html.twig', [
            'entrada' => $entrada,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entradas_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entradas $entrada, EntradasRepository $entradasRepository): Response
    {
        $form = $this->createForm(EntradasType::class, $entrada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entradasRepository->save($entrada, true);

            return $this->redirectToRoute('app_entradas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entradas/edit.html.twig', [
            'entrada' => $entrada,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entradas_delete', methods: ['POST'])]
    public function delete(Request $request, Entradas $entrada, EntradasRepository $entradasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrada->getId(), $request->request->get('_token'))) {
            $entradasRepository->remove($entrada, true);
        }

        return $this->redirectToRoute('app_entradas_index', [], Response::HTTP_SEE_OTHER);
    }
}
