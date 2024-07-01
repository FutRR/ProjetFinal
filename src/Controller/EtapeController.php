<?php

namespace App\Controller;

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
        $niveaux = $niveauRepository->findAll();
        return $this->render('etape/index.html.twig', [
            'niveaux' => $niveaux,
        ]);
    }
}
