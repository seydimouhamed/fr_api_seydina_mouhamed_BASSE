<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class NiveauFixtures extends Fixture
{

    
    public static function getReferenceKey($i)
    {
        return sprintf('niveau_%s',$i);
    }

    public function load(ObjectManager $manager)
    {
        $k=1;
        for($i = 1 ; $i <= 6 ; $i++){
            for($j = 1; $j <= 3; $j++){
                $niveau = new Niveau();
                $niveau->setNumero($j)
                        ->setCritereEvaluation("Critere d evaluation $i niveau $j")
                        ->setGroupeAction(" Groupe d'action $i niveau $j")
                        ->setArchivage(0);

                    $manager->persist($niveau);
                    $this->addReference(self::getReferenceKey($k), $niveau);
                    $k++;
            }
        }

        $manager->flush();
    }
}
