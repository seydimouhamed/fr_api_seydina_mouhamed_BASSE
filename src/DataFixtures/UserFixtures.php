<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Repository\ProfilRepository;
use App\DataFixtures\ProfileFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return array(
            ProfileFixtures::class,
        );
    }

     private $_encoder; 
     private $_profil;
     
    public function __construct(UserPasswordEncoderInterface $_encoder, ProfilRepository $_profil)
    {
        $this->_encoder = $_encoder;
        $this->_profil = $_profil;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');


       

        $libelles = ["ADMIN","FORMATEUR","CM","APPRENANT"];

        foreach($libelles as $lib)
        {
            $nbrUserProfil=2;
            if($lib=="APPRENANT")
            {
                $nbrUserProfil=40;
            }
             
            for($i=1; $i <= $nbrUserProfil; $i++)
            {
                $user = new User();
                $profil=$this->_profil->findByLibelle($lib)[0];
               

                $user-> setProfil($profil);
                $user -> setUsernme(strtolower($lib).$i)
                     -> setFirstname($faker->firstName)
                     ->setLastname($faker->lastName)
                     ->setArchivage(false)
                     ->setPassword($this->_encoder->encodePassword($user, 'passe123'));
                $photo= \fopen($faker->imageUrl($width = 100, $height = 100), 'rb');
                $user->setAvatar($photo);
             $manager->persist($user);
            }

        }
        $manager->flush();
    }
}
