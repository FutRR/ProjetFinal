<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UtilisateurController extends AbstractController
{
    #[Route('/profil', name: 'app_utilisateur')]
    public function index(EntityManagerInterface $entityManager, Utilisateur $utilisateur): Response
    {
        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        return $this->render('utilisateur/index.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }
}
