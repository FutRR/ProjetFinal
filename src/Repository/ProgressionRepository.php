<?php

namespace App\Repository;

use App\Entity\Progression;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Progression>
 */
class ProgressionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Progression::class);
    }

    //    /**
    //     * @return Progression[] Returns an array of Progression objects
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

    //    public function findOneBySomeField($value): ?Progression
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    // public function findByUserOrderByNiveau(Utilisateur $utilisateur): array
    // {
    //     return $this->createQueryBuilder('p')
    //         ->join('p.Etape', 'e')
    //         ->where('p.Utilisateur = :utilisateur')
    //         ->setParameter('utilisateur', $utilisateur)
    //         ->orderBy('e.Niveau', 'ASC')
    //         ->getQuery()
    //         ->getResult();
    // }
}
