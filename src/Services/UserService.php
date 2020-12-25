<?php

namespace App\Services;

use App\Repository\ProfilRepository;
use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserService
{
    private $_iriconverter;
    private $_serializer;
    private $_encoder;
    private $repoProfil;
    private $validator;

    public function __construct(
        IriConverterInterface $_iriconverter,
        SerializerInterface $_serializer,
        UserPasswordEncoderInterface $_encoder,
        ProfilRepository $repoProfil,
        ValidatorInterface $validator)
    {
        $this->_iriconverter = $_iriconverter;
        $this->_serializer = $_serializer;
        $this->_encoder=$_encoder;
        $this->repoProfil=$repoProfil;
        $this->validator =$validator;
    }



    public function add($request, $profil=null)
    {
            $user_data= $request->request->all();
            $profil = $this->_iriconverter->getItemfromIri("/api/admin/profils/".$user_data['idProfil']);


            $user = $this->_serializer->denormalize($user_data,"App\Entity\\".$profil->getLibelle(),true);
            $user->setProfil($profil);
            $avatar=$request->files->get("avatar");
            if($avatar)
            {
                $avatarBlob = fopen($avatar->getRealPath(),"rb");
                 $user->setAvatar($avatarBlob);
            }
           $plainPassword = $this->getRandomPassword();
         //   dd($plainPassword);

         $errors = $this->validator->validate($user);
         if (count($errors)){
             $errors = $this->_serializer->serialize($errors,"json");
             // return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
            return $errors;
         }

            $user->setPlainPassword($plainPassword);
            $user->setPassword($this->_encoder->encodePassword($user,$plainPassword));

            return $user;
    }


    public function getRandomPassword(int $nbr=8)
    {

      return base64_encode(random_bytes($nbr));

     //   return "passe123";
    }
    public function getRandomUserName(int $nbr=6)
    {

      return base64_encode(random_bytes($nbr));

     //   return "passe123";
    }

}