<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TagFixtures extends Fixture
{
    public static function getReferenceKey($i)
    {
        return sprintf('tag_%s',$i);
    }

    public function load(ObjectManager $manager)
    {
        $tab=["HTML5", "php", "javascript", "angular", "wordpress", "bootstrap","json","python","java","joomla","c++","fortran","algo"];
        


        for($i=0;$i<count($tab);$i++)
        {
            $tag=new Tag();
            
            $tag->setLibelle($tab[$i]);

            $tag->setDescriptif("description ".$i);

            $this->addReference(self::getReferenceKey($i), $tag);

            $manager->persist($tag);
        }

        $manager->flush();
    }
}
