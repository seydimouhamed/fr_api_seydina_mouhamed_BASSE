<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReferentielRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
//               "controller"="App\Controller\Referentiel\GetReferentielGroupeCompetence"

/**
 * @ApiResource(
 *  routePrefix="/admin",
 *      itemOperations={
 *           "get_referentiel_id"={ 
 *               "method"="GET", 
 *               "path"="/referentiels/{id}",
 *                "normalization_context"={"groups"={"getRefGrpComp"}},
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "security"="is_granted('IS_AUTHENTICATED_FULLY')",
 *                  "security_message"="Acces non autorisé",
 *          },
 *           "get_referentiel_id_grpecompetence_id2"={
 *               "method"="GET", 
 *                "path"="/referentiels/{id}/grpecompetences/{id2}",
 *                "normalization_context"={"groups"={"getGrpCompComp"}},
 *                "security"="is_granted('IS_AUTHENTICATED_FULLY')",
 *                  "security_message"="Acces non autorisé",
 *          },
 *          "put_competences"={
 *               "method"="PUT", 
 *               "path"="/referentiels/{id}",
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "security"="is_granted('IS_AUTHENTICATED_FULLY')",
 *                  "security_message"="Acces non autorisé",
 *          },
 *          "delete"
 *      },
 *      collectionOperations={
 *           "get_referentiels"={ 
 *               "method"="GET", 
 *               "path"="/referentiels",
 *                "normalization_context"={"groups"={"getRefGrpComp"}},
 *                "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or object==user or is_granted('ROLE_CM'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *           "get_referentiels_grpComptence"={ 
 *               "method"="GET", 
 *               "path"="/referentiels/grpecompetences",
 *                "normalization_context"={"groups"={"getGrpCompComp"}, "enable_max_depth"=true},
 *                "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or object==user or is_granted('ROLE_CM'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *          "post",
 *      },
 *       denormalizationContext={"groups"={"postRef"}}  
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 */
class Referentiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"getRefGrpComp","getGrpCompComp"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getRefGrpComp","getGrpCompComp","postRef"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     * @Groups({"getRefGrpComp","postRef"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"getRefGrpComp"})
     */
    private $programme;

    /**
     * @ORM\Column(type="text")
     * @Groups({"getRefGrpComp","postRef"})
     */
    private $critereAdmission;

    /**
     * @ORM\Column(type="text")
     * @Groups({"getRefGrpComp","postRef"})
     */
    private $critereEvaluation;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, inversedBy="referentiels")
     * @Groups({"getRefGrpComp","getGrpCompComp","postRef"})
     * @ApiSubresource
     */
    private $grpCompetences;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage=false;

    /**
     * @ORM\OneToMany(targetEntity=Promotion::class, mappedBy="referentiel")
     */
    private $promotions;

    /**
     * @ORM\OneToMany(targetEntity=Brief::class, mappedBy="referentiel")
     */
    private $briefs;

    public function __construct($id=null)
    {
        $this->id=$id;
        $this->grpCompetences = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->briefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme()
    {
        if($this->programme){
            $fileStream=\stream_get_contents($this->programme);

            return base64_encode($fileStream);
        }

        return null;
    }

    public function setProgramme($programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getCritereAdmission(): ?string
    {
        return $this->critereAdmission;
    }

    public function setCritereAdmission(string $critereAdmission): self
    {
        $this->critereAdmission = $critereAdmission;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGrpCompetences(): Collection
    {
        return $this->grpCompetences;
    }

    public function addGrpCompetence(GroupeCompetence $grpCompetence): self
    {
        if (!$this->grpCompetences->contains($grpCompetence)) {
            $this->grpCompetences[] = $grpCompetence;
        }

        return $this;
    }

    public function removeGrpCompetence(GroupeCompetence $grpCompetence): self
    {
        $this->grpCompetences->removeElement($grpCompetence);

        return $this;
    }


    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }

    /**
     * @return Collection|Promotion[]
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions[] = $promotion;
            $promotion->setReferentiel($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getReferentiel() === $this) {
                $promotion->setReferentiel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Brief[]
     */
    public function getBriefs(): Collection
    {
        return $this->briefs;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->briefs->contains($brief)) {
            $this->briefs[] = $brief;
            $brief->setReferentiel($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->removeElement($brief)) {
            // set the owning side to null (unless already changed)
            if ($brief->getReferentiel() === $this) {
                $brief->setReferentiel(null);
            }
        }

        return $this;
    }
}
