<?php

namespace App\Controller;

use App\Entity\Etape;
use App\Repository\EtapeRepository;
use App\Repository\NiveauRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EtapeController extends AbstractController
{
    #[Route('/etape', name: 'app_etape')]
    public function index(EtapeRepository $etapeRepository, NiveauRepository $niveauRepository): Response
    {
        $etapes = $etapeRepository->findAll();
        return $this->render('etape/indes.html.twig', [
            'etapes' => $etapes,
        ]);
    }

    #[Route('/etape/{id}', name: 'show_etape')]
    public function show(Etape $etape, EtapeRepository $etapeRepository): Response
    {
        $etapeSuivante = $etapeRepository->findEtapeSuivante($etape);
        $etapePrecedente = $etapeRepository->findEtapePrecedente($etape);


        return $this->render("etape/show.html.twig", [
            'etape' => $etape,
            'etapeSuivante' => $etapeSuivante,
            'etapePrecedente' => $etapePrecedente
        ]);
    }

}
