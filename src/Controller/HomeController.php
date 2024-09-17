<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Post;
use App\Form\AvisType;
use App\Form\FilterType;
use App\Entity\Progression;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        //Progression
        $lastProgress = $entityManager->getRepository(Progression::class)->findLastProgression($user->getId());

        $lastPosts = $entityManager->getRepository(Post::class)->findByUtilisateur($user->getId());

        //Avis
        $message = 'Avis posté';

        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);

        $form->handleRequest($request);

        $utilisateur = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $avis->setUtilisateur($utilisateur);
            $avis = $form->getData();
            $entityManager->persist($avis);
            $entityManager->flush();
            $this->addFlash('success', $message);
            return $this->redirectToRoute('app_home');
        }

        // Filtrage | Réslutats max

        $filtre = $this->createForm(FilterType::class);
        $filtre->handleRequest($request);

        $ordre = 'date_desc'; //ordre par défault
        if ($filtre->isSubmitted() && $filtre->isValid()) {
            $ordre = $filtre->get('ordre')->getData();
        }

        $maxResults = $request->query->getInt('maxResults', 5);

        $queryBuilder = $entityManager->getRepository(Avis::class)->createQueryBuilder('a');

        switch ($ordre) {
            case 'date_asc':
                $queryBuilder->orderBy('a.dateCreation', 'ASC');
                break;
            case 'date_desc':
                $queryBuilder->orderBy('a.dateCreation', 'DESC');
                break;
            case 'note_asc':
                $queryBuilder->orderBy('a.note', 'ASC');
                $queryBuilder->addOrderBy('a.dateCreation', 'DESC');
                break;
            case 'note_desc':
                $queryBuilder->orderBy('a.note', 'DESC');
                $queryBuilder->addOrderBy('a.dateCreation', 'DESC');
                break;
        }

        $queryBuilder->setMaxResults($maxResults);
        $reviews = $queryBuilder->getQuery()->getResult();


        return $this->render('home/index.html.twig', [
            'formAddAvis' => $form,
            'filtre' => $filtre,
            'reviews' => $reviews,
            'maxResults' => $maxResults,
            'lastProgress' => $lastProgress,
            'lastPosts' => $lastPosts
        ]);
    }


}
