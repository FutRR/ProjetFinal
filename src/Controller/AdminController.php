<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route(path: '/admin', name: 'app_admin')]
    public function admin(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (isset($user)) {
            if ($this->isGranted('ROLE_ADMIN')) {

                $utilisateurs = $entityManager->getRepository(Utilisateur::class)->findAll();
                $niveaux = $entityManager->getRepository(Niveau::class)->findAll();

                return $this->render('admin/index.html.twig', [
                    'utilisateurs' => $utilisateurs,
                    'niveaux' => $niveaux
                ]);

            }
        }
        return $this->redirectToRoute('app_home');
    }
}
