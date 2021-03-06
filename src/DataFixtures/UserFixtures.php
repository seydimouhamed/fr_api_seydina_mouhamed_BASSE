<?php

namespace App\DataFixtures;

use App\Entity\Cm;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Repository\ProfilRepository;
use App\DataFixtures\ProfileFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ProfilSortieFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return array(
            ProfileFixtures::class,
            ProfilSortieFixtures::class,
        );
    }
    
    public static function getReferenceAppKey($i)
    {
        return sprintf('app_%s',$i);
    }
    
    public static function getReferenceFormKey($i)
    {
        return sprintf('form_%s',$i);
    }
     private $_encoder; 
     private $_profil;
     private $photo='';
     
    public function __construct(UserPasswordEncoderInterface $_encoder, ProfilRepository $_profil)
    {
        $this->_encoder = $_encoder;
        $this->_profil = $_profil;
    }
    public function load(ObjectManager $manager)
    {

       $faker= Factory::create('fr-FR');
       $this->photo= "";
        for($j=0;$j<=3;$j++)
        {
            $profil=$this->getReference(ProfileFixtures::getReferenceKey($j));
            $nbrUserProfil=4;
            if($profil->getLibelle()=="APPRENANT")
            {
                $nbrUserProfil=64;
            }
             
            for($i=1; $i <= $nbrUserProfil; $i++)
            {
                $user = new User();

                if($profil->getLibelle()=="APPRENANT")
                {
                    $user= $this->getApprenant();
                   
                }
                if($profil->getLibelle()=="FORMATEUR")
                {
                    $user = new Formateur();
                }

                if($profil->getLibelle()=="CM")
                {
                    $user = new Cm();
                }
                $this->addUserCommonInfo($user, $profil, $i);
                if($user instanceof Apprenant){
                    $this->addReference(self::getReferenceAppKey($i), $user);
                }
                if($user instanceof Formateur){
                    $this->addReference(self::getReferenceFormKey($i), $user);
                }
             $manager->persist($user);
            }
        }
        $manager->flush();
    }





    private function getApprenant()
    {
        $faker = Factory::create('fr-FR');
        $keyPS=$faker->numberBetween(0,7);
                    $apprenant= new Apprenant();
                    $apprenant->setGenre($faker->randomElement(['homme','femme']))
                         ->setTelephone($faker->phoneNumber())
                         ->setAdresse($faker->address())
                         ->setStatut(false)
                         ->setProfilSortie($this->getReference(ProfilSortieFixtures::getReferenceKey($keyPS)));
    
        return $apprenant;
    }




    
    private function addUserCommonInfo($user, $profil, $i)
    {
        $faker = Factory::create('fr-FR');
        $user-> setProfil($profil);
        
        $photo= \fopen("https://source.unsplash.com/640x640/?portrait", 'rb');
        // $photo= \fopen($faker->imageUrl($width =640, $height = 640), 'rb');
        $user -> setUsernme(strtolower($profil->getLibelle()).$i)
             -> setFirstname($faker->firstName)
             ->setLastname($faker->lastName)
             ->setEmail($faker->email)
             ->setArchivage(false)
             ->setPassword($this->_encoder->encodePassword($user, 'passe123'));
         $user->setAvatar($photo);

    }
}
