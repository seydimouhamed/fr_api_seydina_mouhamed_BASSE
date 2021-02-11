<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Formateur;
use App\Services\UserService;
use Doctrine\ORM\EntityManager;
use App\Services\SendMailService;
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
    private $_userService;
    private $_sendMail;

    public function __construct(
        UserPasswordEncoderInterface $encoder,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        UserService $_userService,
        SendMailService $_sendMail)
    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->em=$em;
        $this->_userService = $_userService;
        $this->_sendMail = $_sendMail;
        
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
          

        //dd($request);
        //return $this->json('access',  Response::HTTP_ACCEPTED);
        if(!$this->isGranted('ROLE_ADMIN'))
        {
            return $this->json(['message'=>'acces refuse'],Response::HTTP_BAD_REQUEST);
        }
        

        $user = $this->_userService->add($request);
       // return $this->json($user,400);
        if(!($user instanceof User))
        {
            return new JsonResponse($user,Response::HTTP_BAD_REQUEST,[],true);
        }

        $this->em->persist($user);
        $this->em->flush();


        
       // $this->_sendMail->sendMail($user,"Bienvenue");

        return $this->json($user, 201);
     }

     /**
      * @Route(
      *     name="addImg",
      *     path="/api/admin/users/{id}/avatar",
      *     methods={"POST"}
      * )
      */
      public function updateImg(Request $request,int $id)
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
          
          return $this->json($user,201);
       }    
      /**
       * @Route(
       *     name="getCurrentUser",
       *     path="/api/admin/user",
       *     methods={"GET"}
       * )
       */
      public function getCurrentUser()
      {
          $user = $this->getUser();
          
          return $this->json($user,201);
       }

      /**
       * @Route(
       *     name="putUser",
       *     path="/api/admin/users/{id}",
       *     methods={"PUT"}
       * ),
       * @Route(
       *     name="putaprenant",
       *     path="/api/aprenants/{id}",
       *     methods={"PUT"}
       * )
       */
      public function updateUser(Request $request,int $id)
      {
          //recupéré tout les données de la requete
         $user = $this->em->getRepository(User::class)->find($id);

         if(!($this->isGranted('ROLE_ADMIN') ||  $user==$this->getUser()))
         {
            return $this->json('acces denied',400);
         }

          $data =  $request->request->all();
         foreach($data as $key => $d)
         {
                if($key!=="_method" && $key!=='idProfil')
                {
                        $user->{"set".ucfirst($key)}($d);
                    
                }
         }

         $errors = $this->validator->validate($user);
        if (count($errors)){
            $errors = $this->serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }
         $photo=$request->files->get("avatar");
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
