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
    public function __construct(ReferentielService $service, SerializerInterface $serialize,ValidatorInterface $validator)
    {
        $this->validator=$validator;
        $this->service=$service;
        $this->serialize= $serialize;
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

}
