<?php

namespace App\Controller;

use App\Entity\Etape;
use App\Form\EtapeType;
use App\Entity\Progression;
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
    public function index(NiveauRepository $niveauRepository): Response
    {
        $niveaux = $niveauRepository->findAll();
        return $this->render('etape/index.html.twig', [
            'niveaux' => $niveaux,
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
            return $this->redirectToRoute('show_etape', ['id' => $etape->getId()]);
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
        $etapes = $etapeRepository->findBy(['Niveau' => $etape->getNiveau()]);

        $utilisateur = $this->getUser();
        $progression = $entityManager->getRepository(Progression::class)->findOneBy(['Etape' => $etape, 'Utilisateur' => $utilisateur]);

        //On récupère les progressions de l'utilisateur sur les différentes étapes
        $progressionsUtilisateur = $entityManager->getRepository(Progression::class)->findBy(['Utilisateur' => $utilisateur]);

        //On initialise le tableau associatif
        $progressionsMap = [];
        //Pour chaque étape, on récupère l'id de l'étape en tant que clé et l'état de complétion en tant que valeur
        foreach ($progressionsUtilisateur as $progressions) {
            $progressionsMap[$progressions->getEtape()->getId()] = $progressions->isDone();
        }

        if (!$progression) {
            $progression = new Progression();
            $progression->setUtilisateur($utilisateur);
            $progression->setEtape($etape);
            $entityManager->persist($progression);
            $entityManager->flush();
        }

        return $this->render("etape/show.html.twig", [
            'etape' => $etape,
            'etapes' => $etapes,
            'etapeSuivante' => $etapeSuivante,
            'etapePrecedente' => $etapePrecedente,
            'progressionsMap' => $progressionsMap
        ]);
    }
}