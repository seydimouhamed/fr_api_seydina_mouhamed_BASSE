<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  routePrefix="/admin",
 *      collectionOperations={
 *          "getGroupes"={
 *              "path"="/groupes",
 *              "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN'))",
 *              "method"="GET",
 *              "normalization_context"={"groups"={"Default","getGroups","resumeUser","resumePromo"}}
 *           },
 *          "getGroupesApprenant"={
 *              "path"="/groupes/apprenants",
 *              "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN'))",
 *              "method"="GET",
 *              "normalization_context"={"groups"={"Default","getGrpApp","resumeUser"}}
 *           },
 *          "post"
 *      },
 *      itemOperations={
 *          "getGroupe_id"={
 *              "path"="/groupes/{id}",
 *              "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN'))",
 *              "method"="GET",
 *              "normalization_context"={"groups"={"Default","getGroups","resumeUser","resumePromo"}}
 *           },
 *          "addApprenantGroup"={
 *              "path"="/groupes/{id}",
 *              "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN'))",
 *              "method"="PUT"
 *           },
 *          "deleteAppGroup"={
 *              "path"="/groupes/{id}/apprenants/{id2}",
 *              "method"="DELETE",
 *              "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN'))"
 *          }
 *      },
 *       normalizationContext={"groups"={"Default","getGroups","resumeGroup"}}
 * )
 *  
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"getGroups","resumeGroup"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getGroups","getGrpApp","resumeGroup"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"wStatutGroup"})
     * 
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"getGroups","getGrpApp"})
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class)
     * @Groups({"getPromoGpPrincipal"})
     * @Groups({"getGroups","getGrpApp","addApprenant"}) 
     * @ApiSubresource()
     */
    private $apprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupes")
     * @Groups({"getGroups"})
     */
    private $formateurs;

    /**
     * @ORM\OneToMany(targetEntity=EtatBriefGroupe::class, mappedBy="groupe")
     */
    private $etatBriefGroupes;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="groupes",cascade={"persist"})
     * @Groups({"getGroups"})
     */
    private $promotion;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
        $this->etatBriefGroupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(?\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        $this->apprenants->removeElement($apprenant);

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        $this->formateurs->removeElement($formateur);

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
            $etatBriefGroupe->setGroupe($this);
        }

        return $this;
    }

    public function removeEtatBriefGroupe(EtatBriefGroupe $etatBriefGroupe): self
    {
        if ($this->etatBriefGroupes->removeElement($etatBriefGroupe)) {
            // set the owning side to null (unless already changed)
            if ($etatBriefGroupe->getGroupe() === $this) {
                $etatBriefGroupe->setGroupe(null);
            }
        }

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }
}
