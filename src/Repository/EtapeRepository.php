<?php

namespace App\Repository;

use App\Entity\Etape;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etape>
 */
class EtapeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etape::class);
    }

    //    /**
    //     * @return Etape[] Returns an array of Etape objects
    //     */

    public function findByNiveauOrderedByOrder($niveauId)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.Niveau = :niveauId')
            ->setParameter('niveauId', $niveauId)
            ->orderBy('e.ordre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve l'étape suivante dans le même niveau
     */
    public function findEtapeSuivante(Etape $etape): ?Etape
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.Niveau = :niveau')
            ->andWhere('e.ordre > :ordre')
            ->setParameter('niveau', $etape->getNiveau())
            ->setParameter('ordre', $etape->getOrdre())
            ->orderBy('e.ordre', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Trouve l'étape suivante dans le même niveau
     */
    public function findEtapePrecedente(Etape $etape): ?Etape
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.Niveau = :niveau')
            ->andWhere('e.ordre < :ordre')
            ->setParameter('niveau', $etape->getNiveau())
            ->setParameter('ordre', $etape->getOrdre())
            ->orderBy('e.ordre', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }


    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Etape
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
