<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Repository\EtapeRepository;
use App\Repository\NiveauRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NiveauController extends AbstractController
{
    #[Route('/niveau', name: 'app_niveau')]
    public function index(NiveauRepository $niveauRepository): Response
    {
        $niveaux = $niveauRepository->findAll();
        return $this->render('niveau/index.html.twig', [
            'niveaux' => $niveaux,
        ]);
    }

    #[Route('/niveau/{id}', name: 'show_niveau')]
    public function show(Niveau $niveau, EtapeRepository $etapeRepository): Response
    {

        $etapes = $etapeRepository->findBy(['Niveau' => $niveau->getId()]);
        return $this->render("niveau/show.html.twig", [
            'niveau' => $niveau,
            'etapes' => $etapes
        ]);
    }
}
