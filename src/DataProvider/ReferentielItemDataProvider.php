<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use App\Entity\Promotion;
use App\Entity\Referentiel;
use App\Services\PromoService;
use App\Repository\ReferentielRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;

final class ReferentielItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $request;
    private $repo;
    public function __construct(RequestStack $requestStack,ReferentielRepository $repo){
        $this->request=$requestStack->getCurrentRequest();
        $this->repo=$repo;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if($operationName==="get_referentiel_id" || $operationName === "delete"  || "put_competences"){
            return false;
        }
            return Referentiel::class === $resourceClass;
        
    }

    public function getItem(string $resourceClass,$id, string $operationName = null, array $context = []): iterable
    {
       // dd($operationName);
        if($operationName=="get_referentiel_id_grpecompetence_id2"){
            $id2=$this->request->get('id2');
            return $referentiels= $this->repo->findOneByGroupeCompetence($id,$id2);
        }
        
    }
}