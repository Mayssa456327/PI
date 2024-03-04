<?php

namespace App\Repository;

use App\Entity\Hopital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hopital>
 *
 * @method Hopital|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hopital|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hopital[]    findAll()
 * @method Hopital[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HopitalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hopital::class);
    }

    //    /**
    //     * @return Hopital[] Returns an array of Hopital objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Hopital
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function sortByNom(): array
    {
        $qb=  $this->createQueryBuilder('a');
        $qb->orderBy('a.Nom', 'ASC');
        return   $qb->getQuery()->getResult();
    }
    public function sortByNombreChambre(): array
    {
        $qb=  $this->createQueryBuilder('a');
        $qb->orderBy('a.NombreChambre', 'DESC');
        return   $qb->getQuery()->getResult();
    }

    public function findBySearchTerm($searchTerm)
{
    return $this->createQueryBuilder('h')
        ->where('h.Nom LIKE :searchTerm')
        ->setParameter('searchTerm', '%'.$searchTerm.'%')
        ->getQuery()
        ->getResult();
}

}