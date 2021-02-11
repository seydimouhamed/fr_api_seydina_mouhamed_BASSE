<?php
// *              "controller"="App\Controller\Promotion\GetAppFormGprincipal",

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PromotionRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *      routePrefix="/admin",
 *      shortName="promos",
 *      collectionOperations={
 *          "getP"={
 *              "method"="GET",
 *              "path"="/promos",
 *              "normalization_context"={"groups"={"Default","resumePromo","getGrpPrin","resumeUser","resumeGroup"},"enable_max_depth"=true},
 *          },
 *          "get_groupe_principale"={
 *              "method"="GET",
 *              "path"="/promos/principal",
 *              "normalization_context"={"groups"={"Default","resumePromo","getGrpPrin","resumeUser","getGroups"}},
 *          },
 *          "get_apprenant_attente"={
 *              "method"="GET",
 *              "path"="/promos/apprenants/attente",
 *              "normalization_context"={"groups"={"resumePromo","getAppAttente","resumeUser","getGroups"}},
 *          },
 *          "post_add_apprenant"={
 *              "method"="POST",
 *              "path"="/promos",
 *          }
 *      },
 *      itemOperations={
 *          "get_promo_id"={
 *              "method"="GET",
 *              "path"="/promos/{id}",
 *              "normalization_context"={"groups"={"resumePromo","getGrpPrin","resumeUser","resumeGroup"}},
 *          },
 *          "get_promo_id_principal"={
 *              "method"="GET",
 *              "path"="/promos/{id}/principal",
 *              "normalization_context"={"groups"={"resumePromo","getGrpPrin","resumeUser","getGroups"}},
 *          },
 *          "get_promo_id_referentiel"={
 *              "method"="GET",
 *              "path"="/promos/{id}/referentiels",
 *              "normalization_context"={"groups"={"resumePromo","getRef","getGrpCompComp"}},
 *          },
 *          "get_promo_id_referentiel_app_attente"={
 *              "method"="GET",
 *              "path"="/promos/{id}/apprenants/attente",
 *              "normalization_context"={"groups"={"resumePromo","getAppAttente","resumeUser","getGroups"}},
 *          },
 *          "get_promo_id_formateur"={
 *              "method"="GET",
 *              "path"="/promos/{id}/formateurs",
 *              "normalization_context"={"groups"={"resumePromo","resumeUser","getForm"}},
 *          },
 *          "put_promo_referentiel"={
 *              "method"="PUT",
 *              "path"="/promos/{id}/referentiels",
 *              "denormalization_context"={"groups"={"wPromoRef"}},
 *          },
 *          "put_promo_apprenant"={
 *              "method"="PUT",
 *              "path"="/promos/{id}/apprenants",
 *          },
 *          "put_promo_formateur"={
 *              "method"="PUT",
 *              "path"="/promos/{id}/formateurs",
 *              "normalization_context"={"groups"={"resumePromo","resumeUser","getForm"}},
 *          },
 *          "put_groupe_status"={
 *              "method"="PUT",
 *              "path"="/promos/{id}/groupes/{groupe}",
 *              "denormalization_context"={"groups"={"wStatutGroup"}},
 *          },
 *      },
 *      attributes={
 *          "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_CM'))",
 *          "security_message"="Acces non autorisé",
 *      },
 *       normalizationContext={"groups"={"Default","resumePromo","srGrpApprent"}},
 *       denormalizationContext={"groups"={"user:write","formateur:write","promo:wrtite"}}
 * )
 * 
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"getPromoGpPrincipal","resumePromo","srGrpApprent"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"getPromoGpPrincipal","resumePromo","srGrpApprent","wPromoRef","promo:wrtite"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getPromoGpPrincipal","resumePromo","srGrpApprent","wPromoRef", "promo:wrtite"})
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Groups({"getPromoGpPrincipal","resumePromo","wPromoRef", "promo:wrtite"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getPromoGpPrincipal","wPromoRef", "promo:wrtite"})
     */
    private $lieu;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"getPromoGpPrincipal","wPromoRef", "promo:wrtite"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"getPromoGpPrincipal","wPromoRef", "promo:wrtite"})
     */
    private $dateFinPro;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"getPromoGpPrincipal","wPromoRef"})
     */
    private $dateFinReelle;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"getPromoGpPrincipal","wPromoRef", "promo:wrtite"})
     */
    private $fabrique;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"getPromoGpPrincipal"})
     */
    private $status="attente";


    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="promotions")
     * @Groups({"getPromoGpPrincipal","getGrpPrin","getAppAttente","getRef","wPromoRef", "promo:wrtite"})
     */
    private $referentiel;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class)
     * @Groups({"getPromoGpPrincipal","getGrpPrin","getForm"})
     */
    private $formateurs;

    /**
     * @ORM\OneToMany(targetEntity=BriefPromo::class, mappedBy="promo")
     */
    private $briefPromos;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="promo")
     */
    private $chats;

    /**
     * @ORM\Column(type="blob",nullable=true)
     * @Groups({"getPromoGpPrincipal","wPromoRef", "promo:wrtite"})
     *
     */
    private $avatar;

    /**
     * 
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promotion")
     * @Groups({"getPromoGpPrincipal","getGrpPrin","getAppAttente","srGrpApprent","wStatutGroup"})
     * @ApiSubresource(maxDepth=2)
     */
    private $groupes;

    

    public function __construct()
    {
        $this->formateurs = new ArrayCollection();
        $this->briefPromos = new ArrayCollection();
        $this->chats = new ArrayCollection();
        $this->groupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFinPro(): ?\DateTimeInterface
    {
        return $this->dateFinPro;
    }

    public function setDateFinPro(\DateTimeInterface $dateFinPro): self
    {
        $this->dateFinPro = $dateFinPro;

        return $this;
    }

    public function getDateFinReelle(): ?\DateTimeInterface
    {
        return $this->dateFinReelle;
    }

    public function setDateFinReelle(\DateTimeInterface $dateFinReelle): self
    {
        $this->dateFinReelle = $dateFinReelle;

        return $this;
    }

    public function getFabrique(): ?string
    {
        return $this->fabrique;
    }

    public function setFabrique(string $fabrique): self
    {
        $this->fabrique = $fabrique;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
            $briefPromo->setPromo($this);
        }

        return $this;
    }

    public function removeBriefPromo(BriefPromo $briefPromo): self
    {
        if ($this->briefPromos->removeElement($briefPromo)) {
            // set the owning side to null (unless already changed)
            if ($briefPromo->getPromo() === $this) {
                $briefPromo->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chats->contains($chat)) {
            $this->chats[] = $chat;
            $chat->setPromo($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chats->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getPromo() === $this) {
                $chat->setPromo(null);
            }
        }

        return $this;
    }

    public function getAvatar()
    {
        if($this->avatar)
        {
            $stream= \stream_get_contents($this->avatar);
            \fclose($this->avatar);

            return base64_encode($stream);
        }

        return null;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setPromotion($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getPromotion() === $this) {
                $groupe->setPromotion(null);
            }
        }

        return $this;
    }

}
