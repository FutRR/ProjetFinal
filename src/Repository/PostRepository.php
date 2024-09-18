<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function paginatePosts(int $etapeId, int $page, int $limit): Paginator
    {
        return new Paginator(
            $this
                ->createQueryBuilder('p')
                ->andWhere('p.Etape = :etapeId')
                ->setParameter('etapeId', $etapeId)
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit)
                ->orderBy('p.dateCreation', 'DESC')
                ->getQuery()
                ->setHint(Paginator::HINT_ENABLE_DISTINCT, false),
            false
        );
    }

    public function findByUtilisateur(int $utilisateurId)
    {
        return $this->createQueryBuilder('p')
        ->where('p.utilisateur = :utilisateurId')
        ->setParameter('utilisateurId', $utilisateurId)
        ->orderBy('p.dateCreation', 'DESC')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult();
    }

    public function findByParent(int $utilisateurId)
    {
        return $this->createQueryBuilder('p')
        ->innerJoin('p.parent', 'parentPost')
        ->where('parentPost.utilisateur = :utilisateurId')
        ->setParameter('utilisateurId', $utilisateurId)
        ->orderBy('p.dateCreation', 'DESC')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult();
    }


    //    /**
    //     * @return Post[] Returns an array of Post objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Post
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

}
