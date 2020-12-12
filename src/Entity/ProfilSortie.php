<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilSortieRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *       normalizationContext={"groups"={"ps:read"}},
 *       denormalizationContext={"groups"={"ps:write"}},
 *       attributes={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Acces non autorisé",
 *          "pagination_enabled"=true,
 *          "pagination_client_items_per_page"=true, 
 *          "pagination_items_per_page"=5}
 *  )
 * @ORM\Entity(repositoryClass=ProfilSortieRepository::class)
 */
class ProfilSortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"ps:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ps:read","ps:write"})
     * @Assert\NotBlank
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $archivage=false;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profilSortie")
     * @ApiSubresource()
     * @Groups({"ps:read"})
     */
    private $apprenants;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
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
            $apprenant->setProfilSortie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfilSortie() === $this) {
                $apprenant->setProfilSortie(null);
            }
        }

        return $this;
    }
}
