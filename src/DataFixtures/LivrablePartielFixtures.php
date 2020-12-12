<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\LivrablePartiel;
use App\DataFixtures\BriefFixtures;
use App\DataFixtures\NiveauFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LivrablePartielFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return array(
            BriefFixtures::class
        );
    }
    
    public static function getReferenceKey($i)
    {
        return sprintf('livPartiel_%s',$i);
    }

    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr-FR');
        
        
       for($i=1;$i <= 25; $i++){
            $lp=(new LivrablePartiel())
                ->setDelaiAt($faker->datetime)
                ->setCreateAt($faker->datetime)
                ->setType($faker->randomElement(['groupe','indiv']))
                ->setDescription($faker->text)
                ->setEtat($faker->randomElement(['rendu','valide','invalide','assigne']))
                ->setLibelle('livrable partiels '.$i)
                ->setNbreCorrige($faker->numberBetween($min = 10, $max = 20))
                ->setNbreRendu($faker->numberBetween($min = 20, $max = 30));

                for($n=1;$n<=3;$n++)
                {
                    $idRef=$faker->unique(true)->numberBetween(1,17);
                    $lp->addNiveau($this->getReference(NiveauFixtures::getReferenceKey($idRef)));
                }
                $faker->unique($reset = true );

            // $lp->setDelai($fake->datetime)
            //     ->setType($fake->randomElement(['ISAS','Code','modelisation']))
            //     ->setDateCreation($fake->datetime)
            //     ->setDescription($fake->text)
            //     ->setEtat($fake->randomElement(['rendu','valide','invalide','assigne']))
            //     ->setLibelle('libelle promo'.$k. '_'.$i)
            //     ->setNbreCorriger($fake->numberBetween($min = 10, $max = 20))
            //     ->setNbreRendu($fake->numberBetween($min = 20, $max = 30))
            //     ->setBriefMaPromo($tbp);
             
            $this->addReference(self::getReferenceKey($i), $lp);

            $manager->persist($lp);

       }

        $manager->flush();
    }
}
