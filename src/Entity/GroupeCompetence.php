<?php

namespace App\Entity;

use App\Entity\Tag;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeCompetenceRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *      routePrefix="/admin",
 *      shortName="grpecompetences",
 *      collectionOperations={
 *           "get_grpecompetences"={ 
 *               "method"="GET", 
 *               "path"="/grpecompetences",
 *               "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_CM'))",
 *               "security_message"="Acces non autorisé",
 *                "normalization_context"={"groups"={"getGrpComp","getGrpCompComp","gettag"}},
 *          },
 *           "get_grpecompetences_competence"={ 
 *               "method"="GET", 
 *               "path"="/grpecompetences/competences",
 *               "security"="is_granted('ROLE_ADMIN')",
 *               "security_message"="Acces non autorisé",
 *                "normalization_context"={"groups"={"getGrpCompComp"}},
 *          },
 *            "add_grpecompetence"={ 
 *               "method"="POST", 
 *               "path"="/grpecompetences",
 *                "denormalization_context"={"groups"={"postGrpComp"}},
 *               "security" = "is_granted('ROLE_ADMIN')",
 *               "security_message"="Acces non autorisé",
 *          }
 *      },
 *      itemOperations={
 *           "get_grpecompetences_id"={ 
 *               "method"="GET", 
 *               "path"="/grpecompetences/{id}",
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "normalization_context"={"groups"={"getGrpComp","getGrpCompComp","gettag"}},
 *                "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_CM'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *           "get_grpecompetences_id_group"={ 
 *               "method"="GET", 
 *               "path"="/grpecompetences/{id}/competences",
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "normalization_context"={"groups"={"getGrpCompComp"}},
 *                "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_CM'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *
 *            "modifier_grpecompetences_id"={ 
 *               "method"="PUT", 
 *               "path"="/grpecompetences/{id}",
 *                "requirements"={"id"="\d+"},
 *                "denormalization_context"={"groups"={"postCompNiv"}, "enable_max_depth"=true,},
 *                "security" = "is_granted('ROLE_ADMIN')",
 *                  "security_message"="Acces non autorisé",
 *          },
 *          "delete"
 *       },
 *      attributes={"force_eager"=false,}
 * )
 *       denormalizationContext={"groups"={"postGrpComp"}}
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=GroupeCompetenceRepository::class)
 */
class GroupeCompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"getGrpComp","getRefGrpComp"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"getGrpComp","postGrpComp","getRefGrpComp"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Groups({"getGrpComp","postGrpComp","getRefGrpComp"})
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage=false;
    

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="grpCompetences")
     */
    private $referentiels;

    /**
     * @MaxDepth(2)
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupeCompetences",cascade={"persist", "remove"})
     * @Groups({"getGrpComp","getGrpCompComp", "postCompNiv","postGrpComp"})
     * @ApiSubresource
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeCompetences")
     * @Groups({"getGrpComp","getGrpCompComp", "postCompNiv","postGrpComp"})
     */
    private $tags;


    public function __construct()
    {
        $this->referentiels = new ArrayCollection();
        $this->competences = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(?string $descriptif): self
    {
        $this->descriptif = $descriptif;

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
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGrpCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            $referentiel->removeGrpCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        $this->competences->removeElement($competence);

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }


}
