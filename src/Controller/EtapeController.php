<?php

namespace App\Controller;

use App\Entity\Etape;
use App\Form\EtapeType;
use App\Entity\Progression;
use App\Entity\Utilisateur;
use App\Repository\EtapeRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProgressionRepository;
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

    #[Route('/etape/{id}/updateProgression', name: 'updateProgression')]
    public function updateProgression(Etape $etape, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = $this->getUser();
        $progression = $entityManager->getRepository(Progression::class)->findOneBy(['Etape' => $etape, 'Utilisateur' => $utilisateur]);

        if ($progression && !$progression->isDone()) {
            $progression->setDone(true);
            $entityManager->flush();
        } elseif (!$progression) {
            $progression = new Progression();
            $progression->setUtilisateur($utilisateur);
            $progression->setEtape($etape);
            $progression->setDone(true);
            $entityManager->persist($progression);
            $entityManager->flush();
        }

        $etapeSuivante = $entityManager->getRepository(Etape::class)->findEtapeSuivante($etape);

        return $this->redirectToRoute('show_etape', ['id' => $etapeSuivante->getId()]);
    }


    #[Route('/etape/{id}', name: 'show_etape')]
    public function show(Etape $etape, EtapeRepository $etapeRepository, EntityManagerInterface $entityManager): Response
    {
        $etapeSuivante = $etapeRepository->findEtapeSuivante($etape);
        $etapePrecedente = $etapeRepository->findEtapePrecedente($etape);

        $utilisateur = $this->getUser();
        $progression = $entityManager->getRepository(Progression::class)->findOneBy(['Etape' => $etape, 'Utilisateur' => $utilisateur]);

        if (!$progression) {
            $progression = new Progression();
            $progression->setUtilisateur($utilisateur);
            $progression->setEtape($etape);
            $entityManager->persist($progression);
            $entityManager->flush();
        }


        return $this->render("etape/show.html.twig", [
            'etape' => $etape,
            'etapeSuivante' => $etapeSuivante,
            'etapePrecedente' => $etapePrecedente,
            'progression' => $progression
        ]);
    }

}
