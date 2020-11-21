<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormateurRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *      collectionOperations={
 *        "get"={
 *               "method"="GET", 
 *               "path"="/formateurs}",
 *                "security"="( (is_granted('ROLE_ADMIN') or is_granted('ROLE_CM'))",
 *                  "security_message"="Acces non autorisé"
 *         },
 *      },
 *      itemOperations={
 *           "get_formateur_id"={ 
 *               "method"="GET", 
 *               "path"="/formateurs/{id}",
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "security"="(object==user or is_granted('ROLE_ADMIN') or is_granted('ROLE_CM'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *
 *            "modifier_formateur_id"={ 
 *               "method"="PUT", 
 *               "path"="/formateurs/{id}",
 *               "requirements"={"id"="\d+"},
 *                "security"="(object==user  or is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *      },
 *       normalizationContext={"groups"={"user:read","formateur:read"}},
 *       denormalizationContext={"groups"={"user:write","formateur:write"}}
 *  )
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 */
class Formateur extends User
{
}
