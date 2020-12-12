<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Brief;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\NiveauFixtures;
use App\DataFixtures\RessourceFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ReferentielFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BriefFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return array(
            NiveauFixtures::class,
            RessourceFixtures::class,
            UserFixtures::class,
            ReferentielFixtures::class
        );
    }
    public static function getReferenceKey($i)
    {
        return sprintf('brief_%s',$i);
    }
    public function load(ObjectManager $manager)
    {       
         $faker= Factory::create('fr-FR');
         // $k est le pivot qui fait que la ressources soit unique
        $k=1;
        for($i=1;$i <= 5; $i++){
            $brief=new Brief();
                $brief->setTitre("titre brief $i")
                    ->setContexte(" contexte context context $i")
                    ->setListeLivrable('Liste livrable '.$i)
                    ->setDescriptionRapide(" description rapide $i")
                    ->setModaliteEvaluation(" Modalité evaluation $i")
                    ->setModalitePedagogique(" Modalité pédagogique $i")
                    ->setCriterePerformance("Critères de performance $i")
                    ->setLangue($faker->randomElement(['anglais','francais']))
                    ->setEtat($faker->randomElement(['brouillon','valide','assigne']))
                    ->setLimitAt($faker->datetime)
                    ->setCreateAt($faker->datetime);
                
                
                
                //ajouter les ressources
                for($j=1;$j<=2;$j++)
                {
                    $brief->addRessource($this->getReference(RessourceFixtures::getReferenceKey($k)));
                    $k++;
                }

                //ajouter les niveaux
                for($l=1;$l<=5;$l++)
                {
                    $idNiv=$faker->unique(true)->numberBetween(1,17);
                    $brief->addNiveau($this->getReference(NiveauFixtures::getReferenceKey($idNiv)));             
                }
                //add owner=> formateur
                $idForm=$faker->numberBetween(1,4);
                $brief->setOwner($this->getReference(UserFixtures::getReferenceFormKey($idForm)));
                
                //add Referentiel
                $idRef=$faker->numberBetween(1,2);
                $brief->setReferentiel($this->getReference(ReferentielFixtures::getReferenceKey($idRef)));
                
                
                $faker->unique($reset = true );

            $this->addReference(self::getReferenceKey($i), $brief);
               // dd("dans");
                $manager->persist($brief);
                    
        }
        $manager->flush();
    }
}
