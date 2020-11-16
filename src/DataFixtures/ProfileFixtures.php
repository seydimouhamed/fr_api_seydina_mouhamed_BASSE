<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfileFixtures extends Fixture 
{

    public function load(ObjectManager $manager)
    {
        $libelles = ["ADMIN","FORMATEUR","CM","APPRENANT"];

        foreach($libelles as $lib)
        {
            $profil = new Profil();
            $profil-> setLibelle($lib);
            $profil->setArchivage(0);
            $manager->persist($profil);
        }
        
        $manager->flush();
    }
}
