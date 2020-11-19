<?php

namespace App\DataFixtures;

use App\Entity\ProfilSortie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfilSortieFixtures extends Fixture 
{

    
    public static function getReferenceKey($i)
    {
        return sprintf('profilSortie_%s',$i);
    }

    public function load(ObjectManager $manager)
    {
        $profilSortis = ["Développeur front", "back", "fullstack", "CMS", "intégrateur", "designer", "CM", "Data"];

        foreach($profilSortis as $k => $ps)
        {
            $profil = new ProfilSortie();
            $profil-> setLibelle($ps);
            $profil->setArchivage(0);
            $manager->persist($profil);
            $this->addReference(self::getReferenceKey($k), $profil);

        }
        
        $manager->flush();
    }
}
