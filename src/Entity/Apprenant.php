<?php

namespace App\Entity;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *      collectionOperations={
 *           "get_apprenants"={ 
 *               "method"="GET", 
 *               "path"="/apprenants",
 *               "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_CM'))",
 *               "security_message"="Acces non autorisé",
 *          },
 *            "add_apprenant"={ 
 *               "method"="POST", 
 *               "path"="/apprenants",
 *               "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN'))",
 *               "security_message"="Acces non autorisé",
 *          }
 *      },
 *      itemOperations={
 *           "get_apprenants_id"={ 
 *               "method"="GET", 
 *               "path"="/apprenants/{id}",
 *                "defaults"={"id"=null},
 *                "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_APPRENANT') or is_granted('ROLE_CM'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *
 *            "modifier_apprenants_id"={ 
 *               "method"="PUT", 
 *               "path"="/apprenants/{id}",
 *                "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_APPRENANT'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *
 *            "archiver_apprenants_id"={ 
 *               "method"="DELETE", 
 *               "path"="/apprenants/{id}",
 *                "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *       },
 *       normalizationContext={"groups"={"apprenant:read","user:read"}},
 *       denormalizationContext={"groups"={"apprenant:write","user:write"}}
 * 
 * )
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"statut"})
 */
class Apprenant extends User
{
    // /**
    //  * @ORM\Id
    //  * @ORM\GeneratedValue
    //  * @ORM\Column(type="integer")
    //  */
    // private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"apprenant:read", "apprenant:write"})
     * @Assert\NotBlank
     */
    private $genre;

    /**
     * @ORM\Column(type="text")
     * @Groups({"apprenant:read", "apprenant:write","promo:read"})
     * @Assert\NotBlank
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"apprenant:read", "apprenant:write","promo:read"})
     * @Assert\NotBlank
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     * @Groups({"apprenant:read", "apprenant:write","promo:read"})
     */
    private $statut=false;

    /**
     * @ORM\ManyToOne(targetEntity=ProfilSortie::class, inversedBy="apprenants")
     */
    private $profilSortie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getProfilSortie(): ?ProfilSortie
    {
        return $this->profilSortie;
    }

    public function setProfilSortie(?ProfilSortie $profilSortie): self
    {
        $this->profilSortie = $profilSortie;

        return $this;
    }
}
