<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\GroupeTag;
use App\DataFixtures\TagFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GroupeTagFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            TagFixtures::class,
        );
    }
    public static function getReferenceKey($i)
    {
        return sprintf('grouptag_%s',$i);
    }


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        for($i=1;$i<=3;$i++)
        {
            $grpTag=(new GroupeTag())
                ->setLibelle('libelle '.$i)
                ->setArchivage(0);
            for($j=1;$j<=4;$j++)
            {
                $key=$faker->unique(true)->numberBetween(1,12);
                $grpTag->addTag($this->getReference(TagFixtures::getReferenceKey($key)));
            }
            $faker->unique($reset = true );
            $this->addReference(self::getReferenceKey($i), $grpTag);
                $manager->persist($grpTag);
            
        }
        
        $manager->flush();
    }
}
