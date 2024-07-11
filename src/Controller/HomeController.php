<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Form\FilterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
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

        // Filtrage

        $filtre = $this->createForm(FilterType::class);
        $filtre->handleRequest($request);

        $ordre = 'date_desc'; //ordre par défault
        if ($filtre->isSubmitted() && $filtre->isValid()) {
            $ordre = $filtre->get('ordre')->getData();
        }

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

        $queryBuilder->setMaxResults(4);
        $reviews = $queryBuilder->getQuery()->getResult();


        // $query = $entityManager->getRepository(Avis::class)->createQueryBuilder('a')
        //     ->select('a')
        //     ->orderBy('a.dateCreation', 'DESC')
        //     ->setMaxResults(4)
        //     ->getQuery();
        // $reviews = $query->getResult();

        return $this->render('home/index.html.twig', [
            'formAddAvis' => $form,
            'filtre' => $filtre,
            'reviews' => $reviews
        ]);
    }


}
