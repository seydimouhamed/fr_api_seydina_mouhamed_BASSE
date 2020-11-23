<?php

namespace App\Services;

use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserService
{
    private $_iriconverter;
    private $_serializer;
    private $_encoder;
    public function __construct(
        IriConverterInterface $_iriconverter,
        SerializerInterface $_serializer,
        UserPasswordEncoderInterface $_encoder)
    {
        $this->_iriconverter = $_iriconverter;
        $this->_serializer = $_serializer;
        $this->_encoder=$_encoder;
    }



    public function add($request, $profil=null)
    {
            $user_data= $request->request->all();

            $profil = $this->_iriconverter->getItemfromIri($user_data['profil']);
            $user = $this->_serializer->denormalize($user_data,"App\Entity\\".$profil->getLibelle(),true);
            
            $avatar=$request->files->get("avatar");
            if($avatar)
            {
                $avatarBlob = fopen($avatar->getRealPath(),"rb");
                 $user->setAvatar($avatarBlob);
            }
           $plainPassword = $this->getRandomPassword();

            $user->setPlainPassword($plainPassword);
            $user->setPassword($this->_encoder->encodePassword($user,$plainPassword));

            return $user;
    }


    public function getRandomPassword(int $nbr=8)
    {
        // $pw='';
        // for($i=0;$i<8;$i++)
        // {
        //     $pw.=chr(rand(33,126));
        // }

        return base64_encode(random_bytes($nbr));
    }

}