<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Competence;
use App\DataFixtures\NiveauFixtures;
use App\DataFixtures\GroupeTagFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\GroupeCompetenceFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CompetenceFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return array(
            NiveauFixtures::class,
        );
    }
    public static function getReferenceKey($i)
    {
        return sprintf('competence_%s',$i);
    }

    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr-FR');
        $k=1;
        for($i = 1; $i <= 5 ; $i++ ){
            $competence = (new Competence())
                ->setDescriptif('competence '.$i)
                ->setLibelle(" libelle competence ".$i)
                ->setArchivage(0);
            for($j = 0;$j <= 2; $j++){
                $competence->addNiveau($this->getReference(NiveauFixtures::getReferenceKey($k)));
                $k++;
            }
            //$key=$faker->numberBetween(1,3);
            //$competence->setGroupeCompetence($this->getReference(GroupeCompetenceFixtures::getReferenceKey($key)));
            $this->addReference(self::getReferenceKey($i), $competence);
            $manager->persist($competence);
            
        }

        $manager->flush();
    }
}
