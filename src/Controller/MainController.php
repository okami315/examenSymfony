<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ObjetosRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ObjetosRepository $repositoryObjetos): Response
    {
        $objetos = $repositoryObjetos->findBy([], ['ubicacion' => 'DESC']);

        // dd($objetos); Están ordenados descendientemente por el id de ubicación 

        return $this->render('main/index.html.twig', [
            // 'objetos' => $repositoryObjetos->findAll(),
            'objetos'=> $objetos,
        ]);
    }
}

/*
By Chat GPT

public function indexAction()
{
    // Obtén una lista de objetos ordenados por su ubicación
    $objetos = $this->getDoctrine()->getRepository(Objeto::class)->findBy([], ['ubicacion' => 'ASC']);

    return $this->render('objetos/index.html.twig', [
        'objetosPorTipo' => $objetos,
    ]);
}
 */