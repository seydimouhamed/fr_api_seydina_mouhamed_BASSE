<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Ressource;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RessourceFixtures extends Fixture
{
    public static function getReferenceKey($i)
    {
        return sprintf('ressource_%s',$i);
    }
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr-FR');
        
        for($i=1;$i<=20;$i++){
            $ressource=(new Ressource())
                ->setTitre('Resource '.$i);
            $type=$faker->randomElement(['url','file']);
            $ressource->setType($type)
                ->setUrl(" URL $i");

        $this->addReference(self::getReferenceKey($i), $ressource);
        $manager->persist($ressource);
        }
        $manager->flush();
    }
}
