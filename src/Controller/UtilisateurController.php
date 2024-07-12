<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProgressionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateurController extends AbstractController
{

    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    #[Route('/utilisateur/{id}/edit', name: 'edit_utilisateur')]
    public function edit(Utilisateur $utilisateur = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = 'utilisateur modifié';

        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $utilisateur = $form->getData();
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            $this->addFlash('success', $message);
            return $this->redirectToRoute('show_utilisateur', ['id' => $utilisateur->getId()]);
        }

        return $this->render("utilisateur/edit.html.twig", [
            'formAddUtilisateur' => $form,
            'edit' => $utilisateur->getId()
        ]);
    }


    #[Route('/utilisateur/{id}', name: 'show_utilisateur')]
    public function show(Utilisateur $utilisateur, ProgressionRepository $progressionRepository): Response
    {
        $progressions = $progressionRepository->findBy(['Utilisateur' => $utilisateur]);

        //Initialisation du tableau pour stocker les progressions par niveau
        $groupedProgressions = [];

        //Pour chaque progression de l'utilisateur
        foreach ($progressions as $progression) {
            // On récupère le niveau et on le transforme en chaîne de caractères
            $niveau = $progression->getEtape()->getNiveau();
            $niveau = (string) $niveau;

            //Si le tableau n'existe pas, on le créer
            if (!isset($groupedProgressions[$niveau])) {
                $groupedProgressions[$niveau] = [];
            }
            //On ajoute la progression de l'utilisateur au tableau
            $groupedProgressions[$niveau][] = $progression;
        }

        return $this->render("utilisateur/show.html.twig", [
            'utilisateur' => $utilisateur,
            'groupedProgressions' => $groupedProgressions
        ]);
    }

}
