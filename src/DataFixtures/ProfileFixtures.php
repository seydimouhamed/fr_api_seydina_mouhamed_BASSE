<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfileFixtures extends Fixture 
{

    
    public static function getReferenceKey($i)
    {
        return sprintf('profil_%s',$i);
    }

    public function load(ObjectManager $manager)
    {
        $libelles = ["ADMIN","FORMATEUR","CM"];

        foreach($libelles as $k => $lib)
        {
            $profil = new Profil();
            $profil-> setLibelle($lib);
            $profil->setArchivage(0);
            $manager->persist($profil);
            $this->addReference(self::getReferenceKey($k), $profil);

        }
        
        $manager->flush();
    }
}
