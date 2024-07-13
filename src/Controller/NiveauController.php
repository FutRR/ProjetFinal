<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Form\NiveauType;
use App\Repository\EtapeRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/niveau/new', name: 'new_niveau')]
    #[Route('/niveau/{id}/edit', name: 'edit_niveau')]
    public function new_edit(Niveau $niveau = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = $this->getUser();
        if (isset($utilisateur) && $utilisateur->getRoles() == 'ROLE_ADMIN') {

            $isNewNiveau = !$niveau;
            $message = $isNewNiveau ? 'Niveau créé' : 'Niveau modifié';

            if (!$niveau) {
                $niveau = new Niveau();
            }

            $form = $this->createForm(NiveauType::class, $niveau);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $niveau = $form->getData();
                $entityManager->persist($niveau);
                $entityManager->flush();
                $this->addFlash('success', $message);
                return $this->redirectToRoute('app_niveau');
            }

            return $this->render("niveau/new.html.twig", [
                'formAddNiveau' => $form,
                'edit' => $niveau->getId()
            ]);
        } else {
            $this->addFlash('error', "Vous n'avez pas le rôle admin");
            return $this->redirectToRoute("app_home");
        }
    }

    #[Route('/niveau/{id}', name: 'show_niveau')]
    public function show(Niveau $niveau, EtapeRepository $etapeRepository): Response
    {

        $etapes = $etapeRepository->findByNiveauOrderedByOrder($niveau->getId());
        return $this->render("niveau/show.html.twig", [
            'niveau' => $niveau,
            'etapes' => $etapes
        ]);
    }
}
