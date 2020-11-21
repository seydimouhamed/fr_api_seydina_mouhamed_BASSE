<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $encoder;
    private $serializer;
    private $validator;
    private $em;

    public function __construct(
        UserPasswordEncoderInterface $encoder,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $em)
    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->em=$em;
    }
    /**
     * @Route(
     *     name="addUser",
     *     path="/api/admin/users",
     *     methods={"POST"}
     * ),
     * @Route(
     *     name="addApprenant",
     *     path="/api/apprenants",
     *     methods={"POST"}
     * )
     */
    public function add(Request $request)
    {
        //recupéré tout les données de la requete
        $data = $request->request->all();
        
        //recupération de l'image
        $photo = $request->files->get("avatar");
        $data["profil"] = "api/admin/profils/1";

        $user = $this->serializer->denormalize($data,"App\Entity\User",true);
        dd($user);
        $profil=$user->getProfil()->getLibelle();
        if($profil!=="ADMIN")
        {
            $user=$this->serializer->denormalize($data,"App\Entity\\".$profil,true);
            
            //si l'utilisateur est un a apprenant
            if($profil=='APPRENANT')
            {

            }
        }
        
        if($photo)
        {
            $photoBlob = fopen($photo->getRealPath(),"rb");
            
             $user->setAvatar($photoBlob);
        }
        
        $errors = $this->validator->validate($user);
        if (count($errors)){
            $errors = $this->serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }
        $password = $user->getPlainPassword();
        $user->setPassword($this->encoder->encodePassword($user,$password));
        $user->setArchivage(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        
        return $this->json("success",201);
     }

    /**
     * @Route(
     *     name="addImg",
     *     path="/api/admin/users/{id}/avatar",
     *     methods={"POST"}
     * )
     */
    public function addImg(Request $request,int $id)
    {
        //recupéré tout les données de la requete
        
        $user = $this->em->getRepository(User::class)->find($id);


        $photo = $request->files->get("avatar");
        
        if($photo)
        {
            $photoBlob = fopen($photo->getRealPath(),"rb");
            
             $user->setAvatar($photoBlob);
        }
        
    
        $this->em->persist($user);
        $this->em->flush();
        
        return $this->json("success",201);
     }

}
