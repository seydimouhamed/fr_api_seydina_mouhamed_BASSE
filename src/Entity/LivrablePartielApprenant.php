<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablePartielApprenantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=LivrablePartielApprenantRepository::class)
 */
class LivrablePartielApprenant
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
    private $etat;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $delaiAt;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="livrablePartielApprenants")
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=LivrablePartiel::class, inversedBy="livrablePartielApprenants")
     */
    private $livrablePartiel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDelaiAt(): ?\DateTimeInterface
    {
        return $this->delaiAt;
    }

    public function setDelaiAt(?\DateTimeInterface $delaiAt): self
    {
        $this->delaiAt = $delaiAt;

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

    public function getLivrablePartiel(): ?LivrablePartiel
    {
        return $this->livrablePartiel;
    }

    public function setLivrablePartiel(?LivrablePartiel $livrablePartiel): self
    {
        $this->livrablePartiel = $livrablePartiel;

        return $this;
    }
}
