<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use App\Entity\Brief;
use App\Repository\BriefRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class BriefCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $repoBrief;
    private $request;
    public function __construct(
        BriefRepository $repoBrief,
        RequestStack $requestStack)
    {
        $this->repoBrief = $repoBrief;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if($operationName ==="getBriefs"){
             return false;
        }
        
        return Brief::class === $resourceClass;
        
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        
       // dd($this->isGranted('ROLE_ADMIN'));
            $id=$this->request->get('id');
        if($operationName=="getBriefPromoGroupe"){
            $idGroup=$this->request->get('idGroupe');
           
            return $this->repoBrief->findByPromoGroupBrief($id,$idGroup);
        }

        if($operationName=="getBriefPromo"){
           
            return $this->repoBrief->findByPromoBrief($id);
        }

        if($operationName=="getApprenantBriefPromo"){

            return $this->repoBrief->findByPromoBrief($id,0,"assigne");
        }

        if($operationName=="getFormateurBriefBrouillon"){
           
            return $this->repoBrief->findByFormateurBriefEtat($id,"brouillon");
            
        }

        if($operationName=="getFormateurBriefValide"){
           
            return $this->repoBrief->findByFormateurBriefEtat($id,"valide");
            
        }

        if($operationName=="getFormateurPromoBriefId"){
            $idBrief=$this->request->get('idBrief');
           
            return $this->repoBrief->findByPromoBrief($id,$idBrief);
            
        }

        if($operationName=="getApprenantPromoBriefId"){
            $idBrief=$this->request->get('idBrief');
           
            return $this->repoBrief->findByPromoBrief($id,$idBrief,"assigne");
            
        }
        
    }
}