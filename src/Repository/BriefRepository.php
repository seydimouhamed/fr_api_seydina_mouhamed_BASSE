<?php

namespace App\Repository;

use App\Entity\Brief;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Brief|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brief|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brief[]    findAll()
 * @method Brief[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BriefRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brief::class);
    }

    /**
     * @return Brief[] Returns an array of Brief objects
     */
    public function findByPromoGroupBrief($idP,$idG)
    {
        return $this->createQueryBuilder('b')
            ->select('b,ebg,g')
            ->leftJoin('b.etatBriefGroupes','ebg')
            ->leftJoin('ebg.groupe','g')            
            ->andWhere('g.id = :idG')
            ->setParameter('idG', $idG)
            ->leftJoin('g.promotion','p')            
            ->andWhere('p.id = :idP')
            ->setParameter('idP', $idP)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Brief[] Returns an array of Brief objects
     */
    public function findByPromoBrief($idP,$idBrief=null,$etat=null)
    {
        $result= $this->createQueryBuilder('b')
            ->select('b,ebg,bp,p')
            ->leftJoin('b.briefPromos','bp')
            ->leftJoin('bp.promo','p')            
            ->andWhere('p.id =:idP') 
            ->setParameter('idP', $idP)
            ->leftJoin('b.etatBriefGroupes','ebg')            
            ->andWhere('ebg.statut =:statut') 
            ->setParameter('statut', "encours");
            if($idBrief && $idBrief!==0){
                $result->andWhere('b.id =:idBrief') 
                       ->setParameter('idBrief', $idBrief);
            }
            if($etat){
                $result->andWhere('b.etat =:etat') 
                       ->setParameter('etat', $etat);
            }
         return   $result->getQuery()
                        ->getResult();
    }

    /**
     * @return Brief[] Returns an array of Brief objects
     */
    public function findByFormateurBriefEtat($idForm,$etat)
    {
        return $this->createQueryBuilder('b') 
            ->andWhere('b.etat =:etat') 
            ->setParameter('etat', $etat)
            ->leftJoin('b.owner','f')            
            ->andWhere('f.id =:idForm') 
            ->setParameter('idForm', $idForm)
            ->getQuery()
            ->getResult();
    }

    
    

    /*
    public function findOneBySomeField($value): ?Brief
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
