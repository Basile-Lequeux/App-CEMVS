<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetitionsRepository")
 */
class Competitions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $arme;

    /**
     * @ORM\Column(type="integer")
     */
    private $participants;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $blason;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorieAge;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionsUser", mappedBy="competition", orphanRemoval=true)
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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getArme(): ?string
    {
        return $this->arme;
    }

    public function setArme(?string $arme): self
    {
        $this->arme = $arme;

        return $this;
    }

    public function getParticipants(): ?int
    {
        return $this->participants;
    }

    public function setParticipants(int $participants): self
    {
        $this->participants = $participants;

        return $this;
    }

    public function getBlason(): ?string
    {
        return $this->blason;
    }

    public function setBlason(?string $blason): self
    {
        $this->blason = $blason;

        return $this;
    }

    public function getCategorieAge(): ?string
    {
        return $this->categorieAge;
    }

    public function setCategorieAge(string $categorieAge): self
    {
        $this->categorieAge = $categorieAge;

        return $this;
    }

    /**
     * @return Collection|CompetitionsUser[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(CompetitionsUser $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCompetition($this);
        }

        return $this;
    }

    public function removeUser(CompetitionsUser $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCompetition() === $this) {
                $user->setCompetition(null);
            }
        }

        return $this;
    }

}
