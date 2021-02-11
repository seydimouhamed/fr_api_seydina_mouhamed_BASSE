<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 * routePrefix="/admin",
 *      collectionOperations={
 *           "get_competences"={ 
 *               "method"="GET", 
 *               "path"="/competences",
 *               "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_CM'))",
 *               "security_message"="Acces non autorisé",
 *                "normalization_context"={"groups"={"getCompNiv"}},
 *          },
 *           "get_competences_resume"={ 
 *               "method"="GET", 
 *               "path"="/competences/resume",
 *               "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_CM'))",
 *               "security_message"="Acces non autorisé",
 *                "normalization_context"={"groups"={"getCompRes"}},
 *          },
 *            "add_niveaux_competence"={ 
 *               "method"="POST", 
 *               "path"="/competences",
 *                "denormalization_context"={"groups"={"postCompNiv"}},
 *               "security" = "is_granted('ROLE_ADMIN')",
 *               "security_message"="Acces non autorisé",
 *          }
 *      },
 *      itemOperations={
 *           "get_competences_id"={ 
 *               "method"="GET", 
 *               "path"="/competences/{id}",
 *                "normalization_context"={"groups"={"getCompNiv"}},
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_CM'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *
 *            "modifier_competences_id"={ 
 *               "method"="PUT", 
 *               "path"="/competences/{id}",
 *                "denormalization_context"={"groups"={"postCompNiv"}},
 *                "requirements"={"id"="\d+"},
 *                "security" = "is_granted('ROLE_ADMIN')",
 *                  "security_message"="Acces non autorisé",
 *          },
 *          "delete"
 *       },
 *       attributes={
 *          "pagination_enabled"=true,
 *          "pagination_client_items_per_page"=true, 
 *          "pagination_items_per_page"=5}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"getCompNiv","getGrpCompComp","getCompRes"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getCompNiv","postCompNiv","getGrpCompComp","getCompRes"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getCompNiv","postCompNiv"})
     */
    private $descriptif;


    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"getCompNiv","postCompNiv"})
     */
    private $niveaux;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage=false;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="competences")
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=CompetenceValide::class, mappedBy="competence")
     */
    private $competenceValides;

    // /**
    //  * @ORM\ManyToOne(targetEntity=GroupeCompetence::class, inversedBy="competences")
    //  * @Groups({"postCompNiv"})
    //  */
    // private $groupeCompetence;

    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->groupeCompetences = new ArrayCollection();
        $this->competenceValides = new ArrayCollection();
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

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }


 
    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetence() === $this) {
                $niveau->setCompetence(null);
            }
        }

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
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|CompetenceValide[]
     */
    public function getCompetenceValides(): Collection
    {
        return $this->competenceValides;
    }

    public function addCompetenceValide(CompetenceValide $competenceValide): self
    {
        if (!$this->competenceValides->contains($competenceValide)) {
            $this->competenceValides[] = $competenceValide;
            $competenceValide->setCompetence($this);
        }

        return $this;
    }

    public function removeCompetenceValide(CompetenceValide $competenceValide): self
    {
        if ($this->competenceValides->removeElement($competenceValide)) {
            // set the owning side to null (unless already changed)
            if ($competenceValide->getCompetence() === $this) {
                $competenceValide->setCompetence(null);
            }
        }

        return $this;
    }


}
