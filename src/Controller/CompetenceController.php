<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetenceController extends AbstractController
{

    private $serialize;
    private $validator;
    public function __construct( SerializerInterface $serialize,ValidatorInterface $validator)
    {
        $this->validator=$validator;
        $this->serialize= $serialize;
    }
    /**
      * @Route(
      *     name="gettest",
      *     path="/api/test",
      *     methods={"POST"}
      * )
      */

    public function addCompetence(Request $request)
    {
        $data=json_decode($request->getContent(),true);
        foreach($data['competences'] as $key => $idComp)
        {
            $data['competences'][$key]="/api/admin/competences/".$idComp;
        }
        foreach($data['tags'] as $key => $idGrTag)
        {
            $data['tags'][$key] = "/api/admin/grptags/".$idGrTag;
           // dd($data['tags']);
        }
        foreach($data['referentiels'] as $key => $idRef)
        {
            $data['referenvtiels'][$key]= "/api/admin/referentiels/".$idRef;
        }
        $grpCompetence=$this->serialize->denormalize($data,"App\Entity\GroupeCompetence",true);
       
        $errors = $this->validator->validate($grpCompetence);
       if ($errors){
           $errors = $this->serializer->serialize($errors,"json");
           return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
       }
        dd($grpCompetence);
    }

}