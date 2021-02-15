<?php

namespace App\Services;

use App\Repository\PromotionRepository;
use App\Repository\ReferentielRepository;
use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class PromoService
{
    private $_iriconverter;
    private $_serializer;
    private $validator;
    private $repo;

    public function __construct(
        IriConverterInterface $_iriconverter,
        SerializerInterface $_serializer,
        ValidatorInterface $validator,
        PromotionRepository $repo)
    {
        $this->repo= $repo;
    }

    public function getPromoGrpPrincipal($id=null)
    {
        $data=$this->repo->findByGrpPrincipal($id);
         
         return $data;
    }

    public function getApprenantAttente($id=null)
    {
        $data=$this->repo->findByApprenantAttente($id);
     
         return $data;
    }



}