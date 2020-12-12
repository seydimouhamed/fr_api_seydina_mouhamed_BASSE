<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use Doctrine\ORM\Mapping\PostRemove;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *      normalizationContext={"groups"={"profil:read"}},
 *      denormalizationContext={"groups"={"profil:write"}},
 *      itemOperations={
 *           "get_apprenants_id"={ 
 *               "method"="PUT", 
 *               "path"="/profils/{id}",
 *                 "serializer"=false,
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or object==user or is_granted('ROLE_CM'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *          "get",
 *},
 *      attributes={
 *          "security"="is_granted('ROLE_ADMIN') or object==user",
 *          "security_message"="Acces non autorisé",
 *      }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profil:read", "user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"profil:read", "profil:write","user:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $archivage;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @ApiSubresource()
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }

    // /**
    //  * @ORM\PostRemove
    //  */
    // public function removeAllUsers()
    // {
    //     $users= $this->getUsers();
    //     foreach($users as $user)
    //     {
    //         $this->removeUser($user);
    //     }
    // }
}
