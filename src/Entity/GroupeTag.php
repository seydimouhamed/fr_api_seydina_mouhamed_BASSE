<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeTagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *   routePrefix="/admin",
 *   shortName="grptags",
 *      attributes={
 *          "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "security_message"="Acc\ès non autoris\é",
 *      },
 *     collectionOperations={
 *          "get",
 *          "post"={
 *               "method"="POST", 
 *               "path"="/grptags",
 *                "denormalization_context"={"groups"={"postGrpTag"}},
 *               "security" = "is_granted('ROLE_ADMIN')",
 *               "security_message"="Acces non autorisé",
 *              
 *              },
 *      },
 *      itemOperations={
 *             "get",
 *          "put"={
 *               "method"="PUT", 
 *               "path"="/grptags/{id}",
 *                "denormalization_context"={"groups"={"postGrpTag"}},
 *               "security" = "is_granted('ROLE_ADMIN')",
 *               "security_message"="Acces non autorisé",
 *              
 *              }
 *      },
 *       normalizationContext={"groups"={"gettag"}},
 * )
 * @ORM\Entity(repositoryClass=GroupeTagRepository::class)
 */
class GroupeTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"gettag","postGrpTag"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"gettag","postGrpTag"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage=false;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeTags", cascade={"persist"})
     * @Groups({"gettag","postGrpTag"})
     * @ApiSubresource()
     */
    private $tag;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="tags")
     */
    private $groupeCompetences;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
        $this->groupeCompetences = new ArrayCollection();
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
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tag->removeElement($tag);

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
            $groupeCompetence->addTag($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeTag($this);
        }

        return $this;
    }
}
