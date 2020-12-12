<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\BriefPromoFixtures;
use App\Entity\LivrablePartielApprenant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\LivrablePartielFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ApprenantLivrableFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(){
        return array(BriefPromoFixtures::class);
    }
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr-FR');
        // $product = new Product();
        for($i=1;$i<=64; $i++){
            $apprenant=$this->getReference(UserFixtures::getReferenceAppKey($i));
            for($j=1;$j<=3;$j++){
                $keyLp=$faker->unique(true)->numberBetween(1,25);
                $lp=$this->getReference(LivrablePartielFixtures::getReferenceKey($keyLp));

                $apprenantLivrable=(new LivrablePartielApprenant())
                    ->setDelaiAt(new \DateTime())
                    ->setEtat($faker->randomElement(['valide','reprendre','invalide','encours']))
                    ->setApprenant($apprenant)
                    ->setLivrablePartiel($lp);
                    $manager->persist($apprenantLivrable);
            
            }
        }
        
        
        $manager->flush();
    }
}
