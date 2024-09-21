<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Form\PasswordUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProgressionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        $user = $this->getUser();
        if (isset($user)) {
            if ($user == $utilisateur) {

                $message = 'Utilisateur modifié';

                // Si le booléen est nul, la valeur sera false
                $disabled = $utilisateur->isGoogleUser() ?? false;

                $form = $this->createForm(UtilisateurType::class, $utilisateur, ['user_is_google' => $disabled]);

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
            } else {
                $this->addFlash('error', "Ce n'est pas votre profil");
                return $this->redirectToRoute("app_home");
            }

        } else {
            $this->addFlash('error', "Vous n'êtes pas connecté");
            return $this->redirectToRoute("app_home");
        }

    }

    #[Route('utilisateur/{id}/changePassword', name: 'change_password')]
    public function changePassword(Utilisateur $utilisateur, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
        if (isset($user)) {
            if ($user == $utilisateur) {
                if (!$user->isGoogleUser()) {

                    $form = $this->createForm(PasswordUpdateType::class);

                    $form->handleRequest($request);

                    if ($form->isSubmitted() && $form->isValid()) {

                        $currentPassword = $form->get('currentPassword')->getData();
                        $match = $userPasswordHasher->isPasswordValid($utilisateur, $currentPassword);

                        if ($match) {

                            $hashedpassword = $userPasswordHasher->hashPassword(
                                $utilisateur,
                                $form->get('plainPassword')->getData()
                            );
                            $utilisateur->setPassword($hashedpassword);

                            $entityManager->flush();
                            $this->addFlash('success', 'Mot de passe mis à jour');
                            return $this->redirectToRoute('show_utilisateur', ['id' => $utilisateur->getId()]);
                        }
                    }

                    return $this->render("utilisateur/password.html.twig", [
                        'formChangePassword' => $form,
                    ]);
                } else {
                    $this->addFlash('error', "Un utilisateur connecté via compte google ne peut pas changer son mot de passe.");
                    return $this->redirectToRoute('show_utilisateur', ['id' => $utilisateur->getId()]);

                }
            } else {
                $this->addFlash('error', "Ce n'est pas votre profil");
                return $this->redirectToRoute("app_home");
            }

        } else {
            $this->addFlash('error', "Vous n'êtes pas connecté");
            return $this->redirectToRoute("app_home");
        }

    }

    #[Route('/utilisateur/{id}/delete', name: 'delete_utilisateur')]
    public function deleteUtilisateur(Utilisateur $utilisateur, EntityManagerInterface $entityManager, Request $request): Response
    {

        $user = $this->getUser();
        if (isset($user)) {
            //Si l'utilisateur est un admin, le compte ne peut pas être supprimé
            if ($utilisateur->getRoles('ROLE_ADMIN')){
                $this->addFlash('error', "Ce compte appartient à un admin");
                return $this->redirectToRoute("app_home");
            } else {
                    if ($user->getId() == $utilisateur->getId() || $this->isGranted('ROLE_ADMIN')) {

                        if (!$utilisateur) {
                            $this->addFlash('error', "Utilisateur non trouvé");
                            return $this->redirectToRoute("app_home");
                        }

                        $submittedToken = $request->getPayload()->get('token');
                        if ($this->isCsrfTokenValid('delete_utilisateur', $submittedToken)) {
                            if ($user->getId() == $utilisateur->getId()) {
                                $session = new Session();
                                $session->invalidate();
                            }

                            $entityManager->remove($utilisateur);
                            $entityManager->flush();

                            $this->addFlash('success', "Utilisateur supprimé");
                            return $this->redirectToRoute("app_logout");
                        }

                    } else {
                        $this->addFlash('error', "Ce n'est pas votre profil");
                        return $this->redirectToRoute("app_home");
                    }
                }
            }
            $this->addFlash('error', "Vous n'êtes pas connecté");
            return $this->redirectToRoute("app_home");

    }


    #[Route('/utilisateur/{id}', name: 'show_utilisateur')]
    public function show(Utilisateur $utilisateur, ProgressionRepository $progressionRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (isset($user)) {
            if ($user == $utilisateur || $this->isGranted('ROLE_ADMIN')) {

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

                $posts = $entityManager->getRepository(Post::class)->findBy(['utilisateur' => $utilisateur], ['dateCreation' => 'DESC']);

                return $this->render("utilisateur/show.html.twig", [
                    'utilisateur' => $utilisateur,
                    'groupedProgressions' => $groupedProgressions,
                    'posts' => $posts
                ]);

            } else {
                $this->addFlash('error', "Ce n'est pas votre profil");
                return $this->redirectToRoute("app_home");
            }

        } else {
            $this->addFlash('error', "Vous n'êtes pas connecté");
            return $this->redirectToRoute("app_home");
        }

    }
}
