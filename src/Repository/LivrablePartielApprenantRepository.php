<?php

namespace App\Repository;

use App\Entity\LivrablePartielApprenant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LivrablePartielApprenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivrablePartielApprenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivrablePartielApprenant[]    findAll()
 * @method LivrablePartielApprenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivrablePartielApprenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivrablePartielApprenant::class);
    }

    // /**
    //  * @return LivrablePartielApprenant[] Returns an array of LivrablePartielApprenant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LivrablePartielApprenant
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
