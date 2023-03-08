<?php

namespace App\Controller;

use DateTime;
use App\Entity\Salidas;
use App\Entity\Objetos;
use App\Form\SalidasType;
use App\Repository\SalidasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/salidas')]
class SalidasController extends AbstractController
{
    #[Route('/', name: 'app_salidas_index', methods: ['GET'])]
    public function index(SalidasRepository $salidasRepository): Response
    {
        return $this->render('salidas/index.html.twig', [
            'salidas' => $salidasRepository->findAll(),
        ]);
    }

    // Se que lo he hecho de manera perra pero es lo que he sacado (al menos es ingenioso)
    #[Route('/new/{id}/{int}', name: 'app_salidas_new', methods: ['GET', 'POST'])]
    public function new(Objetos $objeto ,Request $request, SalidasRepository $salidasRepository): Response
    {
        // dd($request->get('int'));
        $salida = new Salidas();
        $form = $this->createForm(SalidasType::class, $salida);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // dd($form->get('quantity')->getData()); // Lo que introduzco yo
            // dd(intval($request->get('int'))); // El valor disponible enviado
            // dd(intval($request->get('int'))>=$form->get('quantity')->getData());


            // El intval lo he mirado con chatgpt

            if(intval($request->get('int'))>=$form->get('quantity')->getData()){
            $salida->setObjetos($objeto);
            $salida->setDate(new DateTime());
            $salidasRepository->save($salida, true);
            }
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('salidas/new.html.twig', [
            'salida' => $salida,
            'form' => $form,
            'objeto' => $objeto,
        ]);
    }

    #[Route('/{id}', name: 'app_salidas_show', methods: ['GET'])]
    public function show(Salidas $salida): Response
    {
        return $this->render('salidas/show.html.twig', [
            'salida' => $salida,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_salidas_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Salidas $salida, SalidasRepository $salidasRepository): Response
    {
        $form = $this->createForm(SalidasType::class, $salida);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $salidasRepository->save($salida, true);

            return $this->redirectToRoute('app_salidas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('salidas/edit.html.twig', [
            'salida' => $salida,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_salidas_delete', methods: ['POST'])]
    public function delete(Request $request, Salidas $salida, SalidasRepository $salidasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salida->getId(), $request->request->get('_token'))) {
            $salidasRepository->remove($salida, true);
        }

        return $this->redirectToRoute('app_salidas_index', [], Response::HTTP_SEE_OTHER);
    }
}
