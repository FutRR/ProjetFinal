<?php

namespace App\Controller;

use App\Entity\Progression;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\ProgressionRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        return $this->render("utilisateur/show.html.twig", [
            'utilisateur' => $utilisateur,
            'progressions' => $progressions
        ]);
    }

}
