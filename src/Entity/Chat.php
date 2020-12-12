<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 */
class Chat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $pieceJointe;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="chats")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="chats")
     */
    private $promo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $writeAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }

    public function setPieceJointe($pieceJointe): self
    {
        $this->pieceJointe = $pieceJointe;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getWriteAt(): ?\DateTimeInterface
    {
        return $this->writeAt;
    }

    public function setWriteAt(\DateTimeInterface $writeAt): self
    {
        $this->writeAt = $writeAt;

        return $this;
    }
}
