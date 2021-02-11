<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Formateur;
use App\Services\UserService;
use Doctrine\ORM\EntityManager;
use App\Services\SendMailService;
use App\Repository\UserRepository;
use App\Services\ReferentielService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ReferentielController extends AbstractController
{
    private $service;
    private $serialize;
    private $validator;
    private $em;

    public function __construct(
        EntityManagerInterface $em,
        ReferentielService $service, 
        SerializerInterface $serialize,
        ValidatorInterface $validator)
    {
        $this->validator=$validator;
        $this->service=$service;
        $this->serialize= $serialize;
        $this->em = $em;

    }
    /**
     * @Route(
     *     name="getRefComp",
     *     path="/api/asqqdsdmin/referentiels/{id}/grpecompetences/{id2}",
     *     methods={"GET"}
     * )
     */
    public function getReferencielCompetence($id,$id2)
    {
         $referentiel=$this->service->getReferentielGrpCompetence($id,$id2);

        return $this->json($referentiel,201);
    }
    /**
     * @Route(
     *     name="getRefComp",
     *     path="/api/admin/referentiels",
     *     methods={"POST"}
     * )
     */
    public function postReferenciel(Request $request)
    {
        $data = $request->request->all();
        $data['grpCompetences'] = json_decode($data['grpCompetences'], true);
        $referentiel = $this->serialize->denormalize($data,"App\Entity\Referentiel",true);
        
        $programme = $request->files->get('programme');
        if($programme){
            $programmeBlob = fopen($programme->getRealPath(), "rb");
            $referentiel->setProgramme($programmeBlob);
        }

        // validation des données
        $errors = $this->validator->validate($referentiel);
        if (count($errors)){
            $errors = $this->serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }

        $this->em->persist($referentiel);
        $this->em->flush();
        return $this->json($referentiel,201);
    }


    /**
     * @Route(
     *     name="getRefComp",
     *     path="/api/admin/referentiels/{id}",
     *     methods={"PUT"}
     * )
     */
    public function putReferenciel($id, Request $request)
    {
        $data = $request->request->all();

       // $data['grpCompetences'] = json_decode($data['grpCompetences'], true);
        $referentiel = $this->serialize->denormalize("api/admin/referentiels/$id","App\Entity\Referentiel",true);

        $tab=['libelle', 'presentation', 'critereAdmission', 'critereEvaluation'];

        foreach($tab as $att)
        {
            if($data[$att]){
                $referentiel->{"set".ucfirst($att)}($data[$att]);
            }
        }
        $gCTab = json_decode($data['grpCompetences'], true);

        foreach($gCTab as $gc){

            $gcObject = $this->serialize->denormalize($gc ,"App\Entity\GroupeCompetence",true);
            if($gcObject){
                $referentiel->addGrpCompetence($gcObject);
            }
        }
        
        $programme = $request->files->get('programme');
        if($programme){
            $programmeBlob = fopen($programme->getRealPath(), "rb");
            $referentiel->setProgramme($programmeBlob);
        }

        // validation des données
        $errors = $this->validator->validate($referentiel);
        if (count($errors)){
            $errors = $this->serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }

        $this->em->persist($referentiel);
        $this->em->flush();
        return $this->json($referentiel,201);
    }

}
