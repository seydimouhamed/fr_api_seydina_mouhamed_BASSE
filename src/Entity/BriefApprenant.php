<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BriefApprenantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BriefApprenantRepository::class)
 */
class BriefApprenant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="briefApprenants")
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=BriefPromo::class, inversedBy="briefApprenants")
     */
    private $briefPromo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }

    public function getBriefPromo(): ?BriefPromo
    {
        return $this->briefPromo;
    }

    public function setBriefPromo(?BriefPromo $briefPromo): self
    {
        $this->briefPromo = $briefPromo;

        return $this;
    }
}
