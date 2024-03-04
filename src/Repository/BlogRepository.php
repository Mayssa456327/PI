<?php

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Blog>
 *
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

//    /**
//     * @return Blog[] Returns an array of Blog objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
    /**
     * Search for blogs based on the provided titre and type.
     *
     * @param string|null $titre
     * @param string|null $type
     * @return array
     */
    public function findBySearchQuery(string $searchQuery): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.titre LIKE :query OR b.type LIKE :query')
            ->setParameter('query', '%' . $searchQuery . '%')
            ->getQuery()
            ->getResult();
    }
    /**
     * Get the top 3 blogs with the highest number of comments.
     *
     * @return array
     */
    public function findTop3BlogsByCommentCount(): array
    {
        return $this->createQueryBuilder('b')
            ->select('b.id, b.titre, COUNT(c.id) AS commentCount')
            ->leftJoin('b.comments', 'c')
            ->groupBy('b.id')
            ->orderBy('commentCount', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
    /**
     * Retrieve all blogs ordered by date, most recent first.
     *
     * @return Blog[] Returns an array of Blog objects
     */
    // BlogRepository.php
    public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.date', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?Blog
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
