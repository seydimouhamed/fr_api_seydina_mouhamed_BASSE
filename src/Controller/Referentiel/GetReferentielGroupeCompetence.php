<?php
// api/src/Controller/CreateBookPublication.php

namespace App\Controller\Referentiel;

use App\Entity\Referentiel;
use App\Services\ReferentielService;
use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class GetReferentielGroupeCompetence
{
    private $_iriconverter;
    private $service;
    public function __construct(
        IriConverterInterface $_iriconverter, ReferentielService $service)
    {
        $this->_iriconverter=$_iriconverter;
        $this->service=$service;
    }

    public function __invoke($id,$id2): Referentiel
    {
       
        $data=$this->service->getReferentielGrpCompetence($id,$id2);
      // $gc = $this->_iriconverter->getItemfromIri("/api/admin/grpecompetences/".$id2);
       //dd($gc->getCompetences());
      // $data->setGrpeCompetences($gc);
     // $data->addGrpCompetence($gc);
        
     //  $data->setGr

        return $data;
    }
}