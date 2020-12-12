<?php

namespace App\Services;

use App\Repository\ReferentielRepository;
use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ReferentielService
{
    private $_iriconverter;
    private $_serializer;
    private $validator;
    private $repo;

    public function __construct(
        IriConverterInterface $_iriconverter,
        SerializerInterface $_serializer,
        ValidatorInterface $validator,
        ReferentielRepository $repo)
    {
        $this->_iriconverter = $_iriconverter;
        $this->_serializer = $_serializer;
        $this->validator =$validator;
        $this->repo= $repo;
    }

    public function getReferentielGrpCompetence($id,$id2)
    {
        $data=$this->repo->findOneByGroupeCompetence($id,$id2);
     
         return $data;
    }



}