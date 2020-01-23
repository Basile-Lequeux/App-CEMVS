<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LeconRepository")
 */
class Lecon
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="leconsdonnees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $maitreArme;

    private $rawMaitre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $present;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="lecons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entrainement", inversedBy="lecons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entrainement;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $informations;

    public function __construct()
    {
        $this->entrainement = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaitreArme(): ?User
    {
        return $this->maitreArme;
    }

    public function setMaitreArme(?User $maitreArme): self
    {
        $this->maitreArme = $maitreArme;

        return $this;
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


    public function getEntrainement(): ?Entrainement
    {
        return $this->entrainement;
    }

    public function setEntrainement(?Entrainement $entrainement): self
    {
        $this->entrainement = $entrainement;

        return $this;
    }

    public function getInformations(): ?string
    {
        return $this->informations;
    }

    public function setInformations(?string $informations): self
    {
        $this->informations = $informations;

        return $this;
    }

    /**
     * Get the value of rawMaitre
     */ 
    public function getRawMaitre()
    {
        return $this->rawMaitre;
    }

    /**
     * Set the value of rawMaitre
     *
     * @return  self
     */ 
    public function setRawMaitre($rawMaitre)
    {
        $this->rawMaitre = $rawMaitre;

        return $this;
    }
}
