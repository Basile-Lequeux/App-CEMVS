<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArbitreRepository")
 */
class Arbitre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="zoneArbitre")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Competitions", mappedBy="zoneArbitre")
     */
    private $competitions;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->competitions = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->libelle;
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
            $user->setZoneArbitre($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getZoneArbitre() === $this) {
                $user->setZoneArbitre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Competitions[]
     */
    public function getCompetitions(): Collection
    {
        return $this->competitions;
    }

    public function addCompetition(Competitions $competition): self
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions[] = $competition;
            $competition->setZoneArbitre($this);
        }

        return $this;
    }

    public function removeCompetition(Competitions $competition): self
    {
        if ($this->competitions->contains($competition)) {
            $this->competitions->removeElement($competition);
            // set the owning side to null (unless already changed)
            if ($competition->getZoneArbitre() === $this) {
                $competition->setZoneArbitre(null);
            }
        }

        return $this;
    }   
}
