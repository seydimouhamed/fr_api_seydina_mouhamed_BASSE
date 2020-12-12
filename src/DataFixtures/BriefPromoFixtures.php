<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\BriefPromo;
use App\Entity\EtatBriefGroupe;
use App\DataFixtures\BriefFixtures;
use App\DataFixtures\GroupeFixtures;
use App\DataFixtures\PromotionFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\LivrablePartielFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BriefPromoFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return array( 
            BriefFixtures::class, 
            PromotionFixtures::class,
            LivrablePartielFixtures::class
        );
    }

    public static function getRefencekey($i){
        return \sprintf('briefPromo_%s'.$i);
    }
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr-FR');
        $fak= Factory::create('fr-FR');
        for( $i=0; $i < 2; $i++){
          $promo=$this->getReference(PromotionFixtures::getReferenceKey($i));
          // entity EtatBriefGroupe
            $groups=$promo->getGroupes();
          
          for($j=0;$j<=2;$j++){
            $idBrief=$faker->unique(true)->numberBetween(1,5);
            $brief=$this->getReference(BriefFixtures::getReferenceKey($idBrief));

            
            $briefPromo=(new BriefPromo())
                ->setPromo($promo)
                ->setBrief($brief);
                for($f=1;$f<=5;$f++){
                    $idLp=$fak->unique(true)->numberBetween(1,25);
                    $lp=$this->getReference(LivrablePartielFixtures::getReferenceKey($idLp));
                    $briefPromo->addLivrablePartiel($lp);
                }
                $fak->unique($reset=true);
        //---------------------------------------//
        // Fixtures pour l'entity EtatBriefGroup //
        //---------------------------------------//
                foreach($groups as $group)
                {
                    $briefGroup=(new EtatBriefGroupe())
                        ->setGroupe($group)
                        ->setBrief($brief)
                        ->setStatut($faker->randomElement(['close','encours','valide','invalide']));

                    $manager->persist($briefGroup);
                }
            $manager->persist($briefPromo);

          }
          $faker->unique($reset=true);
        }
        $manager->flush();
    }
}
