<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min=5)
     */
    private $rawPassword;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\NotNull
     */
     private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\NotNull
     */
     private $blason;

     /**
     * @ORM\Column(type="datetime")
     */

     private $createdAt;

     

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\UserObjectifs", mappedBy="user", orphanRemoval=true)
      */
     private $objectifs;

    

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\Lecon", mappedBy="user", orphanRemoval=true)
      */
     private $lecons;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\Lecon", mappedBy="maitreArme", orphanRemoval=true)
      */
      private $leconsdonnees;

     /**
      * @ORM\ManyToOne(targetEntity="App\Entity\Groupe", inversedBy="users")
      * @ORM\JoinColumn(nullable=false)
      */
     private $groupe;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\EntrainementUser", mappedBy="user", orphanRemoval=true)
      */
     private $entrainements;

     /**
      * @ORM\ManyToOne(targetEntity="App\Entity\UserArme", inversedBy="users")
      */
     private $arme;

     /**
      * @ORM\Column(type="string", length=255, nullable=true)
      */
     private $categorieAge;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\CompetitionsUser", mappedBy="user", orphanRemoval=true)
      */
     private $competitions;

     /**
      * @ORM\ManyToOne(targetEntity="App\Entity\UserArbitre", inversedBy="users")
      */
     private $arbitre;

     /**
      * @ORM\Column(type="date", nullable=true)
      */
     private $DateNaissance;

     /**
      * @ORM\Column(type="string", length=255)
      */
     private $Nom;

     /**
      * @ORM\Column(type="string", length=255)
      */
     private $prenom;

     

     

     public function __construct()
     {
         $this->objectifs = new ArrayCollection();
         $this->lecons = new ArrayCollection();
         $this->entrainements = new ArrayCollection();
         $this->competitions = new ArrayCollection();
     }
    
    public function __toString()
    {
        return (string) $this->username;
    }

    /**
     * Assert\Callback()
     */
    public function assertIsValid(ExecutionContextInterface $context)
    {
        if ($this->getId() === null && $this->getRawPassword() === null) {
            $context
                ->buildViolation('Le mot de passe ne peut pas être vide')
                ->aPath('rawPassword')
                ->addViolation();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
    public function getRoles()
    {
        return [
            $this->getRole(),
        ];
    }
    public function getSalt()
    {
        return null;
    }
    public function eraseCredentials()
    {
        $this->rawPassword = null;
    }
     /**
     * Get RawPassword
     *
     * @return string|null
     */
    public function getRawPassword() : ? string
    {
        return $this->rawPassword;
    }
    /**
     * Set RawPassword
     *
     * @param string|null $rawPassword
     */
    public function setRawPassword(? string $rawPassword) : void
    {
        $this->rawPassword = $rawPassword;
    }


     /**
      * Get the value of genre
      */ 
     public function getGenre()
     {
          return $this->genre;
     }

     /**
      * Set the value of genre
      *
      * @return  self
      */ 
     public function setGenre($genre)
     {
          $this->genre = $genre;

          return $this;
     }

     /**
      * Get the value of blason
      */ 
     public function getBlason()
     {
          return $this->blason;
     }

     /**
      * Set the value of blason
      *
      * @return  self
      */ 
     public function setBlason($blason)
     {
          $this->blason = $blason;

          return $this;
     }

     /**
      * Get the value of createdAt
      */ 
     public function getCreatedAt()
     {
          return $this->createdAt;
     }

     /**
      * Set the value of createdAt
      *
      * @return  self
      */ 
     public function setCreatedAt($createdAt)
     {
          $this->createdAt = $createdAt;

          return $this;
     }

    

     /**
      * @return Collection|UserObjectifs[]
      */
     public function getObjectifs(): Collection
     {
         return $this->objectifs;
     }

     public function addObjectif(UserObjectifs $objectif): self
     {
         if (!$this->objectifs->contains($objectif)) {
             $this->objectifs[] = $objectif;
             $objectif->setUser($this);
         }

         return $this;
     }

     public function removeObjectif(UserObjectifs $objectif): self
     {
         if ($this->objectifs->contains($objectif)) {
             $this->objectifs->removeElement($objectif);
             // set the owning side to null (unless already changed)
             if ($objectif->getUser() === $this) {
                 $objectif->setUser(null);
             }
         }

         return $this;
     }

     public function getGroupe(): ?Groupe
     {
         return $this->groupe;
     }

     public function setGroupe(Groupe $groupe): self
     {
         $this->groupe = $groupe;

         // set the owning side of the relation if necessary
         if ($this !== $groupe->getUsers()) {
             $groupe->addUser($this);
         }

         return $this;
     }
     
    //  public function addGroupe(Groupe $groupe): self
    // {
    //     if (!$this->groupe->contains($groupe)) {
    //         $this->groupe[] = $groupe;
    //     }

    //     return $this;
    // }


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
             $lecon->setUser($this);
         }

         return $this;
     }

     public function removeLecon(Lecon $lecon): self
     {
         if ($this->lecons->contains($lecon)) {
             $this->lecons->removeElement($lecon);
             // set the owning side to null (unless already changed)
             if ($lecon->getUser() === $this) {
                 $lecon->setUser(null);
             }
         }

         return $this;
     }

     /**
      * @return Collection|EntrainementUser[]
      */
     public function getEntrainements(): Collection
     {
         return $this->entrainements;
     }

     public function addEntrainement(EntrainementUser $entrainement): self
     {
         if (!$this->entrainements->contains($entrainement)) {
             $this->entrainements[] = $entrainement;
             $entrainement->setUser($this);
         }

         return $this;
     }

     public function removeEntrainement(EntrainementUser $entrainement): self
     {
         if ($this->entrainements->contains($entrainement)) {
             $this->entrainements->removeElement($entrainement);
             // set the owning side to null (unless already changed)
             if ($entrainement->getUser() === $this) {
                 $entrainement->setUser(null);
             }
         }

         return $this;
     }

     public function getArme(): ?UserArme
     {
         return $this->arme;
     }

     public function setArme(?UserArme $arme): self
     {
         $this->arme = $arme;

         return $this;
     }

     public function getCategorieAge(): ?string
     {
         return $this->categorieAge;
     }

     public function setCategorieAge(?string $categorieAge): self
     {
         $this->categorieAge = $categorieAge;

         return $this;
     }

     /**
      * @return Collection|CompetitionsUser[]
      */
     public function getCompetitions(): Collection
     {
         return $this->competitions;
     }

     public function addCompetition(CompetitionsUser $competition): self
     {
         if (!$this->competitions->contains($competition)) {
             $this->competitions[] = $competition;
             $competition->setUser($this);
         }

         return $this;
     }

     public function removeCompetition(CompetitionsUser $competition): self
     {
         if ($this->competitions->contains($competition)) {
             $this->competitions->removeElement($competition);
             // set the owning side to null (unless already changed)
             if ($competition->getUser() === $this) {
                 $competition->setUser(null);
             }
         }

         return $this;
     }

     public function getArbitre(): ?UserArbitre
     {
         return $this->arbitre;
     }

     public function setArbitre(?UserArbitre $arbitre): self
     {
         $this->arbitre = $arbitre;

         return $this;
     }

     public function getDateNaissance(): ?\DateTimeInterface
     {
         return $this->DateNaissance;
     }

     public function setDateNaissance(?\DateTimeInterface $DateNaissance): self
     {
         $this->DateNaissance = $DateNaissance;

         return $this;
     }

     public function getNom(): ?string
     {
         return $this->Nom;
     }

     public function setNom(string $Nom): self
     {
         $this->Nom = $Nom;

         return $this;
     }

     public function getPrenom(): ?string
     {
         return $this->prenom;
     }

     public function setPrenom(string $prenom): self
     {
         $this->prenom = $prenom;

         return $this;
     }



}
