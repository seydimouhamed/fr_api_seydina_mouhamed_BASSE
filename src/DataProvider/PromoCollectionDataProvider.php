<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use App\Entity\Promotion;
use App\Services\PromoService;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class PromoCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $service;
    public function __construct(PromoService $service){
        $this->service=$service;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if($operationName!=="getP"){
             return Promotion::class === $resourceClass;
        }
        else
        {
            return false;
        }
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        if($operationName === "get_groupe_principale"){

           $data=$this->service->getPromoGrpPrincipal();
           return $data;
        }
        if($operationName=== "get_apprenant_attente")
        {
           // dd('apprenant');
           $resourceClass=$this->service->getPromoGrpPrincipal();
          // dd($resourceClass);
           return $resourceClass;
        }
        return new Promotion();
    }
}