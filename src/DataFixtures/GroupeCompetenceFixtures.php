<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\GroupeCompetence;
use App\DataFixtures\NiveauFixtures;
use App\DataFixtures\GroupeTagFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\CompetenceFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GroupeCompetenceFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return array(
            CompetenceFixtures::class,
            \App\DataFixtures\TagFixtures::class,
        );
    }

    public static function getReferenceKey($i)
    {
        return sprintf('gc_%s',$i);
    }
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr-FR');
        for($i = 1; $i <= 3; $i++)
        {
            $gc = new GroupeCompetence();
            $gc -> setLibelle("libelle gc $i")
                -> setDescriptif(" descriptif gc $i")
                -> setArchivage(0);
            
            $nbrComptences = $faker -> randomElement([2,3]);

            for($j=1 ;$j <= $nbrComptences;$j++ )
            {
                $key=$faker->unique(true)->numberBetween(1,5);
                $gc->addCompetence($this->getReference(CompetenceFixtures::getReferenceKey($key)));
            }
            
            //$this->addReference(self::getReferenceKey($i), $gc);
             $faker->unique($reset = true );

             $nbrTags = $faker -> randomElement([3,7]);

            for($k=1 ;$k <= $nbrTags;$k++ )
            {
                $key=$faker->unique(true)->numberBetween(1,12);
                $gc->addTag($this->getReference(TagFixtures::getReferenceKey($key)));
            }
            $faker->unique($reset = true );
          //  dd($gc);
            $this->addReference(self::getReferenceKey($i), $gc);
             $manager->persist($gc);

        }

        $manager->flush();
    }
}
