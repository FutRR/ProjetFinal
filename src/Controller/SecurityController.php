<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $utilisateur = $this->getUser();
        if (!isset($utilisateur)) {

            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();

            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();


            return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error,
                'show_footer' => false,
            ]);
        } else {
            return $this->redirectToRoute('app_home');
        }

    }

    #[Route(path: '/login_message', name: 'login_message')]
    public function loginMessage()
    {
        $this->addFlash('success', 'Connecté');
        return $this->redirectToRoute('app_home');
    }


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        $this->addFlash('success', 'Déconnecté');
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/logout_message', name: 'logout_message')]
    public function logoutMessage()
    {
        $this->addFlash('success', 'Déconnecté');
        return $this->redirectToRoute('app_home');
    }

}
