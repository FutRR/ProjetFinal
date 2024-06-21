<?php

namespace App\Controller;

use App\Repository\NiveauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
