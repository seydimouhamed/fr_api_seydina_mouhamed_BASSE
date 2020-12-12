<?php

namespace App\Repository;

use App\Entity\Promotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Promotion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promotion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promotion[]    findAll()
 * @method Promotion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
    }

    // /**
    //  * @return Promotion[] Returns an array of Promotion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

   
    public function findByGrpPrincipal($id=null)
    {
     // if()
        $result= $this->createQueryBuilder('p')
             ->select('p,g,a')
            ->leftJoin('p.groupes', 'g')
            ->andWhere('g.type =:type')
            ->setParameter('type', "principal")
            ->leftJoin('g.apprenants', 'a')
            ->andWhere('a.archivage =:isArchive')
            ->setParameter('isArchive', false);
    //si l'id n'est pas null on cherche la promo de par son id
            if($id)
            {
                $result->andWhere('p.id =:idPromo')
                    ->setParameter('idPromo', $id);
            }
            $result=$result->getQuery()
                ->getResult();
            //    dd($result);
        //return $result;
        return $result;
    }
   
    public function findByApprenantAttente($id=null)
    {
      
        $result= $this->createQueryBuilder('p')
             ->select('p,g,a')
            ->leftJoin('p.groupes', 'g')
            ->andWhere('g.type =:type')
            ->setParameter('type', "principal")
            ->leftJoin('g.apprenants', 'a')
            ->andWhere('a.statut =:statut')
            ->setParameter('statut', false)
            ->andWhere('a.archivage =:isArchive')
            ->setParameter('isArchive', false);
    //si l'id n'est pas null on cherche la promo de par son id
            if($id)
            {
                $result->andWhere('p.id =:idPromo')
                    ->setParameter('idPromo', $id);
            }
            return $result->getQuery()->getResult();
        
    }
    
}
