<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Etape;
use App\Form\PostType;
use App\Form\EtapeType;
use App\Entity\Progression;
use App\Repository\EtapeRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
    public function new_edit(Etape $etape = null, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $utilisateur = $this->getUser();
        if (isset($utilisateur) && $this->isGranted('ROLE_ADMIN')) {

            $isNewEtape = !$etape;
            $message = $isNewEtape ? 'Étape créé' : 'Étape modifié';

            if (!$etape) {
                $etape = new Etape();
            }

            $form = $this->createForm(EtapeType::class, $etape);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $pdfFile = $form->get('pdf')->getData();

                //Le fichier pdf n'est que pris en compte s'il est upload
                if ($pdfFile) {
                    $originalFilename = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $extension = $pdfFile->guessExtension();
                    $existingFiles = glob($this->getParameter('pdf_directory') . '/' . $safeFilename . '-*.' . $extension);

                    // on vérifie si le fichier existe deja dans le dossier /pdf
                    if (empty($existingFiles)) {
                        $newFilename = $safeFilename . '-' . uniqid() . '.' . $extension;
                        try {
                            $pdfFile->move($this->getParameter('pdf_directory'), $newFilename);
                            $etape->setPdf('pdf/' . $newFilename);
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Erreur lors de l\'upload du fichier PDF : ' . $e->getMessage());
                            return $this->redirectToRoute('form_etape', ['id' => $etape->getId()]);
                        }
                    } else {
                        $this->addFlash('info', 'Le fichier existe déjà et n\'a pas été re-téléchargé.');
                        $etape->setPdf(str_replace($this->getParameter('pdf_directory') . '/', 'pdf/', $existingFiles[0]));
                    }

                } elseif (!$isNewEtape && $form->get('pdf')->isRequired()) {
                    // Si c'est une édition et que le champ PDF est explicitement vidé
                    $etape->setPdf(null);
                }
                // Si aucun nouveau fichier n'est uploadé et que ce n'est pas une suppression explicite,
                // on garde l'ancien PDF (pas besoin de code supplémentaire car l'entité n'est pas modifiée)


                $entityManager->persist($etape);
                $entityManager->flush();
                noty()->success($message);
                return $this->redirectToRoute('show_etape', ['id' => $etape->getId()]);
            }

            return $this->render("etape/new.html.twig", [
                'formAddEtape' => $form,
                'edit' => $etape->getId()
            ]);

        } else {
            $this->addFlash('error', "Vous n'avez pas le rôle admin");
            return $this->redirectToRoute("app_home");
        }

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

        if ($etapeSuivante) {
            return $this->redirectToRoute('show_etape', ['id' => $etapeSuivante->getId()]);
        } else {
            return $this->redirectToRoute('app_home');
        }
    }


    #[Route('/post/reply/{postId}', name: 'post_reply', methods: ["POST"])]
    public function postReply(Request $request, EntityManagerInterface $entityManager, int $postId): Response
    {
        $post = $entityManager->getRepository(Post::class)->find($postId);
        $utilisateur = $this->getUser();

        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        $reply = new Post();
        $form = $this->createForm(PostType::class, $reply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reply->setUtilisateur($utilisateur);
            $reply->setEtape($post->getEtape());
            $reply->setParent($post);
            $entityManager->persist($reply);
            $entityManager->flush();
            noty()->success('Réponse publiée');
            return $this->redirectToRoute('show_etape', ['id' => $post->getEtape()->getId()]);
        }

        return $this->redirectToRoute('show_etape', ['id' => $post->getEtape()->getId()]);
    }


    #[Route('/etape/{id}', name: 'show_etape')]
    public function show(Etape $etape, EtapeRepository $etapeRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $etapeSuivante = $etapeRepository->findEtapeSuivante($etape);
        $etapePrecedente = $etapeRepository->findEtapePrecedente($etape);
        $etapes = $etapeRepository->findBy(['Niveau' => $etape->getNiveau()]);

        $user = $this->getUser();

        if (isset($user)) {
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

            //S'il n'y à pas de progression, on en créer une et lui attribue l'utilisateur connecté et l'étape concernée
            if (!$progression) {
                $progression = new Progression();
                $progression->setUtilisateur($utilisateur);
                $progression->setEtape($etape);
                $entityManager->persist($progression);
                $entityManager->flush();
            }

            $posts = $entityManager->getRepository(Post::class)->findBy(['Etape' => $etape]);

            // Formulaire de post
            $message = 'Post publié';

            $post = new Post();
            $formPost = $this->createForm(PostType::class, $post);
            $formPost->handleRequest($request);

            if ($formPost->isSubmitted() && $formPost->isValid()) {
                $post->setUtilisateur($utilisateur);
                $post->setEtape($etape);
                $entityManager->persist($post);
                $entityManager->flush();
                noty()->success($message);
                return $this->redirectToRoute('show_etape', ['id' => $etape->getId()]);
            }

            // Création des formulaires de réponse pour chaque post
            $reponseForms = [];
            foreach ($posts as $post) {
                $form = $this->createForm(PostType::class, null, [
                    'action' => $this->generateUrl('post_reply', ['postId' => $post->getId()]),
                ]);
                $reponseForms[$post->getId()] = $form->createView();
            }


            return $this->render("etape/show.html.twig", [
                'etape' => $etape,
                'etapes' => $etapes,
                'etapeSuivante' => $etapeSuivante,
                'etapePrecedente' => $etapePrecedente,
                'progressionsMap' => $progressionsMap,
                'posts' => $posts,
                'formAddPost' => $formPost->createView(),
                'reponseForms' => $reponseForms,
            ]);

        } else {
            noty()->error("Vous n'êtes pas connecté");
            return $this->redirectToRoute("app_home");
        }

    }
}
