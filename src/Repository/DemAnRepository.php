<?php

namespace App\Repository;

use App\Entity\DemAn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemAn>
 *
 * @method DemAn|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemAn|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemAn[]    findAll()
 * @method DemAn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemAnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemAn::class);
    }

//    /**
//     * @return DemAn[] Returns an array of DemAn objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DemAn
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
