<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BriefPromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BriefPromoRepository::class)
 */
class BriefPromo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="briefPromos")
     */
    private $brief;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="briefPromos")
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity=BriefApprenant::class, mappedBy="briefPromo")
     */
    private $briefApprenants;

    /**
     * @ORM\OneToMany(targetEntity=LivrablePartiel::class, mappedBy="briefPromo")
     */
    private $livrablePartiels;

    public function __construct()
    {
        $this->briefApprenant = new ArrayCollection();
        $this->livrablePartiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

    public function getPromo(): ?Promotion
    {
        return $this->promo;
    }

    public function setPromo(?Promotion $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * @return Collection|BriefApprenant[]
     */
    public function getBriefApprenant(): Collection
    {
        return $this->briefApprenant;
    }

    public function addBriefApprenant(BriefApprenant $briefApprenant): self
    {
        if (!$this->briefApprenant->contains($briefApprenant)) {
            $this->briefApprenant[] = $briefApprenant;
            $briefApprenant->setBriefPromo($this);
        }

        return $this;
    }

    public function removeBriefApprenant(BriefApprenant $briefApprenant): self
    {
        if ($this->briefApprenant->removeElement($briefApprenant)) {
            // set the owning side to null (unless already changed)
            if ($briefApprenant->getBriefPromo() === $this) {
                $briefApprenant->setBriefPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LivrablePartiel[]
     */
    public function getLivrablePartiels(): Collection
    {
        return $this->livrablePartiels;
    }

    public function addLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if (!$this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels[] = $livrablePartiel;
            $livrablePartiel->setBriefPromo($this);
        }

        return $this;
    }

    public function removeLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if ($this->livrablePartiels->removeElement($livrablePartiel)) {
            // set the owning side to null (unless already changed)
            if ($livrablePartiel->getBriefPromo() === $this) {
                $livrablePartiel->setBriefPromo(null);
            }
        }

        return $this;
    }
}
