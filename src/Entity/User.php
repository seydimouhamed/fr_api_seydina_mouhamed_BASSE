<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="disc", type="string")
 * @ORM\DiscriminatorMap({"admin"="User","apprenant"="Apprenant","Formateur","cm"="Cm"})
 * @ApiResource(
 *     routePrefix="/admin",
 *       normalizationContext={"groups"={"user:read"}},
 *       denormalizationContext={"groups"={"user:write"}},
 *       attributes={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Acces non autorisé",
 *          "pagination_enabled"=true, 
 *          "pagination_items_per_page"=3}
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read","profil:read"})
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
     * @Groups({"user:write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write","profil:read"})
     * @Assert\NotBlank
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write","profil:read"})
     * @Assert\NotBlank
     */
    private $lastname;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $archivage;

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
     * @Assert\Unique
     */
    private $email;

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
       
        if($this->avatar!==null){
            $content = \stream_get_contents($this->avatar);
            fclose($this->avatar);
            
            return base64_encode($content);
        }

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
}
