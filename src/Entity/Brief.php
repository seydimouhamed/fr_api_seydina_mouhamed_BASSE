<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "getBriefs"={
 *              "method"="GET",
 *              "path"="/formateurs/briefs",
 *                "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_CM') or is_granted('ROLE_FORMATEUR'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *          "getBriefPromoGroupe"={
 *              "method"="GET",
 *              "path"="/formateurs/promo/{id}/groupe/{idGroupe}/briefs",
 *          },
 *          "getBriefPromo"={
 *              "method"="GET",
 *              "path"="/formateurs/promo/{id}/briefs",
 *          },
 *          "getApprenantBriefPromo"={
 *              "method"="GET",
 *              "path"="/apprenants/promos/{id}/briefs",
 *          },
 *          "getFormateurBriefBrouillon"={
 *              "method"="GET",
 *              "path"="/formateurs/{id}/briefs/brouillons",
 *                "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *          "getFormateurBriefValide"={
 *              "method"="GET",
 *              "path"="/formateurs/{id}/briefs/valide",
 *                "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *                "security_message"="Acces non autorisé",
 *          },
 *          "getFormateurPromoBriefId"={
 *              "method"="GET",
 *              "path"="/formateurs/promos/{id}/briefs/{idBrief}",
 *                "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *                "security_message"="Acces non autorisé",
 *          },
 *          "getApprenantPromoBriefId"={
 *              "method"="GET",
 *              "path"="/apprenants/promos/{id}/briefs/{idBrief}",
 *                "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_APPRENANT'))",
 *                "security_message"="Acces non autorisé",
 *          },
 *          
 *      }
 * )
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 */
class Brief
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contexte;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="text")
     */
    private $listeLivrable;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $limitAt;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionRapide;

    /**
     * @ORM\Column(type="text")
     */
    private $modalitePedagogique;

    /**
     * @ORM\Column(type="text")
     */
    private $criterePerformance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modaliteEvaluation;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $imageExemplaire;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $langue;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class)
     */
    private $niveaux;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="briefs")
     */
    private $referentiel;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="briefs")
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $etat;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage=false;

    /**
     * @ORM\OneToMany(targetEntity=Ressource::class, mappedBy="brief")
     */
    private $ressources;

    /**
     * @ORM\OneToMany(targetEntity=BriefPromo::class, mappedBy="brief")
     */
    private $briefPromos;

    /**
     * @ORM\OneToMany(targetEntity=EtatBriefGroupe::class, mappedBy="brief")
     */
    private $etatBriefGroupes;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="briefs")
     */
    private $tags;

    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->ressources = new ArrayCollection();
        $this->briefPromos = new ArrayCollection();
        $this->etatBriefGroupes = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContexte(): ?string
    {
        return $this->contexte;
    }

    public function setContexte(string $contexte): self
    {
        $this->contexte = $contexte;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getListeLivrable(): ?string
    {
        return $this->listeLivrable;
    }

    public function setListeLivrable(string $listeLivrable): self
    {
        $this->listeLivrable = $listeLivrable;

        return $this;
    }

    public function getLimitAt(): ?\DateTimeInterface
    {
        return $this->limitAt;
    }

    public function setLimitAt(?\DateTimeInterface $limitAt): self
    {
        $this->limitAt = $limitAt;

        return $this;
    }

    public function getDescriptionRapide(): ?string
    {
        return $this->descriptionRapide;
    }

    public function setDescriptionRapide(string $descriptionRapide): self
    {
        $this->descriptionRapide = $descriptionRapide;

        return $this;
    }

    public function getModalitePedagogique(): ?string
    {
        return $this->modalitePedagogique;
    }

    public function setModalitePedagogique(string $modalitePedagogique): self
    {
        $this->modalitePedagogique = $modalitePedagogique;

        return $this;
    }

    public function getCriterePerformance(): ?string
    {
        return $this->criterePerformance;
    }

    public function setCriterePerformance(string $criterePerformance): self
    {
        $this->criterePerformance = $criterePerformance;

        return $this;
    }

    public function getModaliteEvaluation(): ?string
    {
        return $this->modaliteEvaluation;
    }

    public function setModaliteEvaluation(string $modaliteEvaluation): self
    {
        $this->modaliteEvaluation = $modaliteEvaluation;

        return $this;
    }

    public function getImageExemplaire()
    {
        return $this->imageExemplaire;
    }

    public function setImageExemplaire($imageExemplaire): self
    {
        $this->imageExemplaire = $imageExemplaire;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

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
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        $this->niveaux->removeElement($niveau);

        return $this;
    }

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

        return $this;
    }

    public function getOwner(): ?Formateur
    {
        return $this->owner;
    }

    public function setOwner(?Formateur $owner): self
    {
        $this->owner = $owner;

        return $this;
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
     * @return Collection|Ressource[]
     */
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): self
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources[] = $ressource;
            $ressource->setBrief($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): self
    {
        if ($this->ressources->removeElement($ressource)) {
            // set the owning side to null (unless already changed)
            if ($ressource->getBrief() === $this) {
                $ressource->setBrief(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefPromo[]
     */
    public function getBriefPromos(): Collection
    {
        return $this->briefPromos;
    }

    public function addBriefPromo(BriefPromo $briefPromo): self
    {
        if (!$this->briefPromos->contains($briefPromo)) {
            $this->briefPromos[] = $briefPromo;
            $briefPromo->setBrief($this);
        }

        return $this;
    }

    public function removeBriefPromo(BriefPromo $briefPromo): self
    {
        if ($this->briefPromos->removeElement($briefPromo)) {
            // set the owning side to null (unless already changed)
            if ($briefPromo->getBrief() === $this) {
                $briefPromo->setBrief(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EtatBriefGroupe[]
     */
    public function getEtatBriefGroupes(): Collection
    {
        return $this->etatBriefGroupes;
    }

    public function addEtatBriefGroupe(EtatBriefGroupe $etatBriefGroupe): self
    {
        if (!$this->etatBriefGroupes->contains($etatBriefGroupe)) {
            $this->etatBriefGroupes[] = $etatBriefGroupe;
            $etatBriefGroupe->setBrief($this);
        }

        return $this;
    }

    public function removeEtatBriefGroupe(EtatBriefGroupe $etatBriefGroupe): self
    {
        if ($this->etatBriefGroupes->removeElement($etatBriefGroupe)) {
            // set the owning side to null (unless already changed)
            if ($etatBriefGroupe->getBrief() === $this) {
                $etatBriefGroupe->setBrief(null);
            }
        }

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
