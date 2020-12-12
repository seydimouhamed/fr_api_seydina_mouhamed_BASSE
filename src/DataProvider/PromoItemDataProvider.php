<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use App\Entity\Promotion;
use App\Services\PromoService;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;

final class PromoItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $service;
    public function __construct(PromoService $service){
        $this->service=$service;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if($operationName==="get_promo_id" || ($operationName==='get_promo_id_referentiel' || "get_promo_id_formateur")){
           // dd($operationName === 'get_promo_id_referentiel');
            return false;
        }
        else
        {
            return Promotion::class === $resourceClass;
        }
    }

    public function getItem(string $resourceClass,$id, string $operationName = null, array $context = []): iterable
    {
        
        if($operationName === "get_promo_id_principal"){

           $resourceClass=$this->service->getPromoGrpPrincipal($id);
           return $resourceClass;
        }
        if($operationName=== "get_promo_id_referentiel_app_attente")
        {
           // dd('apprenant');
           $resourceClass=$this->service->getApprenantAttente($id);
          // dd($resourceClass);
           return $resourceClass;
        }
        
       // return new Promotion();
    }
}