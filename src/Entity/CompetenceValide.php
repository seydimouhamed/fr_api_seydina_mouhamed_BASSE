<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetenceValideRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CompetenceValideRepository::class)
 */
class CompetenceValide
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau3;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="competenceValides")
     */
    private $competence;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="competenceValides")
     */
    private $apprenant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau1(): ?string
    {
        return $this->niveau1;
    }

    public function setNiveau1(string $niveau1): self
    {
        $this->niveau1 = $niveau1;

        return $this;
    }

    public function getNiveau2(): ?string
    {
        return $this->niveau2;
    }

    public function setNiveau2(string $niveau2): self
    {
        $this->niveau2 = $niveau2;

        return $this;
    }

    public function getNiveau3(): ?string
    {
        return $this->niveau3;
    }

    public function setNiveau3(string $niveau3): self
    {
        $this->niveau3 = $niveau3;

        return $this;
    }

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): self
    {
        $this->competence = $competence;

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
}
