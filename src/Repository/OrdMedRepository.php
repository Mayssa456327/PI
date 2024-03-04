<?php

namespace App\Repository;

use App\Entity\OrdMed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrdMed>
 *
 * @method OrdMed|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdMed|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdMed[]    findAll()
 * @method OrdMed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdMedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdMed::class);
    }

//    /**
//     * @return OrdMed[] Returns an array of OrdMed objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrdMed
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
