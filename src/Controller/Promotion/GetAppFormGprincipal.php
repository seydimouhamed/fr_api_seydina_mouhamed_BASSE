<?php
// api/src/Controller/CreateBookPublication.php

namespace App\Controller\Promotion;

use App\Entity\Promotion;
use App\Entity\Referentiel;
use App\Services\ReferentielService;
use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class GetAppFormGprincipal
{
    
    public function __construct()
    {
    }

    public function __invoke($data): Promotion
    {
        dd($data);

        return $data;
    }
}