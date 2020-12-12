<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablePartielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=LivrablePartielRepository::class)
 */
class LivrablePartiel
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
    private $libelle;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $delaiAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbreRendu;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class)
     */
    private $niveaux;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbreCorrige;

    /**
     * @ORM\OneToMany(targetEntity=LivrablePartielApprenant::class, mappedBy="livrablePartiel")
     */
    private $livrablePartielApprenants;

    /**
     * @ORM\ManyToOne(targetEntity=BriefPromo::class, inversedBy="livrablePartiels")
     */
    private $briefPromo;

    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->livrablePartielApprenants = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNbreRendu(): ?int
    {
        return $this->nbreRendu;
    }

    public function setNbreRendu(int $nbreRendu): self
    {
        $this->nbreRendu = $nbreRendu;

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

    public function getNbreCorrige(): ?int
    {
        return $this->nbreCorrige;
    }

    public function setNbreCorrige(?int $nbreCorrige): self
    {
        $this->nbreCorrige = $nbreCorrige;

        return $this;
    }

    /**
     * @return Collection|LivrablePartielApprenant[]
     */
    public function getLivrablePartielApprenants(): Collection
    {
        return $this->livrablePartielApprenants;
    }

    public function addLivrablePartielApprenant(LivrablePartielApprenant $livrablePartielApprenant): self
    {
        if (!$this->livrablePartielApprenants->contains($livrablePartielApprenant)) {
            $this->livrablePartielApprenants[] = $livrablePartielApprenant;
            $livrablePartielApprenant->setLivrablePartiel($this);
        }

        return $this;
    }

    public function removeLivrablePartielApprenant(LivrablePartielApprenant $livrablePartielApprenant): self
    {
        if ($this->livrablePartielApprenants->removeElement($livrablePartielApprenant)) {
            // set the owning side to null (unless already changed)
            if ($livrablePartielApprenant->getLivrablePartiel() === $this) {
                $livrablePartielApprenant->setLivrablePartiel(null);
            }
        }

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
