<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="disc", type="string")
 * @ORM\DiscriminatorMap({"admin"="User","apprenant"="Apprenant","formateur"="Formateur","cm"="Cm"})
 * @ApiResource(
 *     routePrefix="/admin",
 *      collectionOperations={
 *          "get",
 *          "post"={
 *              "validation_groups"={"Default", "create"}
 *          },
 *     },
 *       normalizationContext={"groups"={"user:read","resumeUser"}},
 *       denormalizationContext={"groups"={"user:write"}},
 *       attributes={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Acces non autorisé",
 *          "pagination_enabled"=true,
 *          "pagination_client_items_per_page"=true, 
 *          "pagination_items_per_page"=5}
 *    
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ApiFilter(SearchFilter::class, properties={"id":"exact","profil.libelle": "exact"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Orm\Table("`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read","profil:read","resumeUser"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read", "user:write","profil:read"})
     * @Assert\NotBlank
     */
    private $usernme;

    // /**
    //  * @ORM\Column(type="json")
    //  */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;


    // /**
    //  * @Groups("user:write")
    //  * @Assert\NotBlank(groups={"create"})
    //  */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write","profil:read","resumeUser"})
     * @Assert\NotBlank
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write","profil:read","resumeUser"})
     * @Assert\NotBlank
     */
    private $lastname;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $archivage=false;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"user:read", "user:write","profil:read"})
     */
    private $avatar;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @Groups({"user:read", "user:write"})
     */
    private $profil;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write","profil:read"})
     * @Assert\Email
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="user")
     */
    private $chats;

    public function __construct()
    {
        $this->chats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsernme(): ?string
    {
        return $this->usernme;
    }

    public function setUsernme(string $usernme): self
    {
        $this->usernme = $usernme;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->usernme;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    /**
    * @see UserInterface
    */
   public function getPlainPassword(): string
   {
    // if($this->password)
    // {
    //     $this->plainPassword =$this->password;
    //     return $this;
    // }
       return (string) $this->plainPassword;
   }

   public function setPlainPassword(string $plainPassword): self
   {
       
       $this->plainPassword = $plainPassword;

       return $this;
   }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getAvatar()
    {
       
        // if($this->avatar!==null || $this->avatar!==""){
        //     $content = \stream_get_contents($this->avatar);
        //     fclose($this->avatar);
            
        //     return base64_encode($content);
        // }

        return null;
    }

    public function setAvatar($avatar): self
    {
        
        $this->avatar = $avatar;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
            $chat->setUser($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chats->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getUser() === $this) {
                $chat->setUser(null);
            }
        }

        return $this;
    }
}
