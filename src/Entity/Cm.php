<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\CmRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *          routePrefix="/cm",
 *       normalizationContext={"groups"={"user:read","cm:read"}},
 *       denormalizationContext={"groups"={"user:write","cm:write"}}
 * )
 * @ORM\Entity(repositoryClass=CmRepository::class)
 */
class Cm extends User
{
    

}
