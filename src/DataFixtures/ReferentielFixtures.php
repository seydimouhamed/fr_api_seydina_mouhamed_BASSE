<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Referentiel;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\GroupeCompetenceFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ReferentielFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return array(
            GroupeCompetenceFixtures::class
        );
    }

    public static function getReferenceKey($i)
    {
        return sprintf('referentiel_%s',$i);
    }
    public function load(ObjectManager $manager)
    {
       $faker= Factory::create('fr-FR');

       
        for($i=1;$i<=2;$i++)
        {
            $key=$faker->unique(true)->numberBetween(4,);
            $referentiel=(new Referentiel())
                    ->setLibelle("Referntiel ".$i)
                    ->setPresentation("Présentation ref ".$i)
                    ->setCritereAdmission("Critere admission ".$i)
                    ->setCritereEvaluation("Critère d evaluation ".$i)
                    ->setProgramme('rb')
                    //->setProgramme( \fopen($faker->imageUrl($width =640, $height = 640), 'rb'))
                    ->setArchivage(false);

                $nbrGrpComp = $faker->numberBetween(1,3);
                for($p=1 ; $p <=$nbrGrpComp; $p++){
                    $key=$faker->unique(true)->numberBetween(1,3);
                    $referentiel->addGrpCompetence($this->getReference(GroupeCompetenceFixtures::getReferenceKey($p)));
                }
                //

                    $this->addReference(self::getReferenceKey($i), $referentiel);
                $manager->persist($referentiel);
        }


        $manager->flush();
    }
}
