<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrainementRepository")
 * @ApiResource
 */
class Entrainement
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
     * @ORM\OneToMany(targetEntity="App\Entity\Lecon", mappedBy="entrainement", orphanRemoval=true)
     */
    private $lecons;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EntrainementUser", mappedBy="entrainements", orphanRemoval=true)
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Groupe", inversedBy="entrainements")
     */
    private $groupes;

    public function __construct()
    {
        $this->lecons = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->groupes = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->id;
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


    /**
     * @return Collection|Lecon[]
     */
    public function getLecons(): Collection
    {
        return $this->lecons;
    }

    public function addLecon(Lecon $lecon): self
    {
        if (!$this->lecons->contains($lecon)) {
            $this->lecons[] = $lecon;
            $lecon->setEntrainement($this);
        }

        return $this;
    }

    public function removeLecon(Lecon $lecon): self
    {
        if ($this->lecons->contains($lecon)) {
            $this->lecons->removeElement($lecon);
            // set the owning side to null (unless already changed)
            if ($lecon->getEntrainement() === $this) {
                $lecon->setEntrainement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EntrainementUser[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(EntrainementUser $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setEntrainements($this);
        }

        return $this;
    }

    public function removeUser(EntrainementUser $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getEntrainements() === $this) {
                $user->setEntrainements(null);
            }
        }

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
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->contains($groupe)) {
            $this->groupes->removeElement($groupe);
        }

        return $this;
    }
}
