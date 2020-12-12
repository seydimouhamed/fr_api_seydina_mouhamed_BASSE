<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Promotion;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ReferentielFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\UserFixtures;

class PromotionFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return array(
            ReferentielFixtures::class
        );
    }


    public static function getReferenceKey($i)
    {
        return sprintf('promo_%s',$i);
    }


    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr-FR');

        $titre=["Amadou hampathé ba", "Rose dieng kunz"];
        $status=["close","encours"];
        for($i=0;$i<=1;$i++)
        {
            $promo=new Promotion();
            $promo->setTitre($titre[$i])
                  ->setLangue($faker -> randomElement(["frnaçais","Anglais"]))
                  ->setLieu($faker -> randomElement(["Dakar","Pikine","Paris"]))
                  ->setStatus($status[$i])
                  ->setFabrique($faker -> randomElement(["Sonatel Academi","ODC"]))
                  ->setDateDebut($faker->datetime)
                  ->setDateFinPro($faker->datetime)
                  ->setDateFinReelle($faker->datetime)
                  ->setAvatar('')
                 // ->setAvatar(\fopen($faker->imageUrl($width =640, $height = 640), 'rb'))
                  //->setDateFinReelle()
                  ->setDescription($faker->text);
                //----------------------
                // ADD referentiel
                //----------------------
            $promo->setReferentiel($this->getReference(ReferentielFixtures::getReferenceKey($i+1)));
            
                //------------------------//
                //    ADD  formateur      //
                //------------------------//  
            for( $j = 1 ;$j <= 4; $j++)
            {
                $promo->addFormateur($this->getReference(UserFixtures::getReferenceFormKey($j)));
            }
                  
            $this->addReference(self::getReferenceKey($i), $promo);
            $manager->persist($promo);

        }

        $manager->flush();
    }
}
