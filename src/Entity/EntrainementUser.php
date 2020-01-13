<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrainementUserRepository")
 */
class EntrainementUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $present;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="entrainements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entrainement", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entrainements;
  
    
    public function __toString()
    {
        return (string) $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresent(): ?bool
    {
        return $this->present;
    }

    public function setPresent(bool $present): self
    {
        $this->present = $present;

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

    public function getEntrainements(): ?Entrainement
    {
        return $this->entrainements;
    }

    public function setEntrainements(?Entrainement $entrainements): self
    {
        $this->entrainements = $entrainements;

        return $this;
    }




}
