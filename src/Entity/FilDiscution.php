<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FilDiscutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=FilDiscutionRepository::class)
 */
class FilDiscution
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="filDiscution")
     */
    private $commentaires;

    /**
     * @ORM\OneToOne(targetEntity=LivrablePartielApprenant::class, cascade={"persist", "remove"})
     */
    private $appLivPartiel;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setFilDiscution($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getFilDiscution() === $this) {
                $commentaire->setFilDiscution(null);
            }
        }

        return $this;
    }

    public function getAppLivPartiel(): ?LivrablePartielApprenant
    {
        return $this->appLivPartiel;
    }

    public function setAppLivPartiel(?LivrablePartielApprenant $appLivPartiel): self
    {
        $this->appLivPartiel = $appLivPartiel;

        return $this;
    }
}
