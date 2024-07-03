<?php

namespace App\Controller;

use App\Entity\Etape;
use App\Form\EtapeType;
use App\Repository\EtapeRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/etape/new', name: 'new_etape')]
    #[Route('/etape/{id}/edit', name: 'edit_etape')]
    public function new_edit(Etape $etape = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        $isNewEtape = !$etape;
        $message = $isNewEtape ? 'Étape créé' : 'Étape modifié';

        if (!$etape) {
            $etape = new Etape();
        }

        $form = $this->createForm(EtapeType::class, $etape);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $etape = $form->getData();
            $entityManager->persist($etape);
            $entityManager->flush();
            $this->addFlash('success', $message);
            return $this->redirectToRoute('app_etape');
        }

        return $this->render("etape/new.html.twig", [
            'formAddEtape' => $form,
            'edit' => $etape->getId()
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
