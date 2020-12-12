<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Groupe;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\PromotionFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GroupeFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            PromotionFixtures::class
        );
    }

    public function load(ObjectManager $manager)
    {
        $fake= Factory::create('fr-FR');
        $types=['principal','fil rouge', 'binome','repartition'];
        $nbrGroupe = 2;
        $nbrApp = 32;
        $nbrForm = 4;
        $pApp=1;
        $pForm=1;
        foreach($types as $t)
        {
            if($t ==="fil rouge"){
                $nbrGroupe = 16;
                $nbrApp = 4;
                $nbrForm=1;
            }
            if($t === "binome"){
                $nbrGroupe = 32;
                $nbrApp = 2;
                $nbrForm=1;
            }
            if($t === "repartition"){
                $nbrGroupe = 8;
                $nbrApp = 8;
                $nbrForm=1;
            }
            
            for( $i = 1; $i <= $nbrGroupe; $i++ )
            {
                $groupe=new Groupe();

                $groupe->setCreateAt(null)
                       ->setName($t."_".$i)
                       ->setType($t)
                       ->setStatut($fake->randomElement(['encours','ferme']));
                for($a = 1 ;$a <= $nbrApp; $a++){
                    $groupe->addApprenant($this->getReference(UserFixtures::getReferenceAppKey($pApp)));
                    $pApp++;
                    if($pApp > 64){
                        $pApp=1;
                    }
                }

                for($f=1;$f <= $nbrForm; $f++){
                    $groupe->addFormateur($this->getReference(UserFixtures::getReferenceFormKey($pForm)));
                    $pForm++;
                    if($pForm > 4){
                        $pForm = 1;
                    }
                }
              //  dd($groupe);
              //mettre dans la promo 1 si impaire et dans promo2 si paire!
                if($i%2===0)
                {
                
                    $groupe->setPromotion($this->getReference(PromotionFixtures::getReferenceKey(1)));
                }
                else{
                    $groupe->setPromotion($this->getReference(PromotionFixtures::getReferenceKey(0)));
                }
                
                $manager->persist($groupe);
            }

        }
        

        $manager->flush();
    }
    // private function addGroupe($type,$i)
    // {
    //     $groupe=new Groupe();

    //     $groupe->setCreateAt(new \DateTime())
    //            ->setName($type."_".$i)
    //            ->setType($type)
    //            ->setStatut($fake->randomElement(['encours','ferme']));
               
    // }
}
