<?php

namespace App\Repository;

use App\Entity\WishMovie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WishMovie|null find($id, $lockMode = null, $lockVersion = null)
 * @method WishMovie|null findOneBy(array $criteria, array $orderBy = null)
 * @method WishMovie[]    findAll()
 * @method WishMovie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishMovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WishMovie::class);
    }

    // /**
    //  * @return WishMovie[] Returns an array of WishMovie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WishMovie
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
