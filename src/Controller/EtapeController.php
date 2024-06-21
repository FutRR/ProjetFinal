<?php

namespace App\Controller;

use App\Repository\EtapeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EtapeController extends AbstractController
{
    #[Route('/etape', name: 'app_etape')]
    public function index(EtapeRepository $etapeRepository): Response
    {
        $etapes = $etapeRepository->findAll();
        return $this->render('etape/indes.html.twig', [
            'etapes' => $etapes,
        ]);
    }
}
