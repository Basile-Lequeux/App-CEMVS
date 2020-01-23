<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Groupe;
use App\Entity\UserArbitre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixture extends Fixture
{
    private $passwordEncoder;

         public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }
    
    
    public function load(ObjectManager $manager)
    {
        //groupe
       
        $fgroupe = new groupe();
        $fgroupe->setNom('fgroupe');


        //user arbitre
        
        $arbitref = new userArbitre();
        $arbitref->setNiveauArbitre('niveau');


        //user admin
        $adminf = new user();
        $adminf->setUsername('Adminf');
        $adminf->setPassword($this->passwordEncoder->encodePassword($adminf,'azerty'));
        $adminf->setRole('ROLE_ADMIN');
        $adminf->setGenre('homme');
        $adminf->setArbitre($arbitref);
        $adminf->setBlason('Jaune');
        $adminf->setCreatedAt( new \DateTime("2020-01-06 00:00:00"));
        $adminf->setGroupe($fgroupe);
        $adminf->setCategorieAge('Seniors');
        $adminf->setArme($armef);
        $adminf->setdateNaissance( new \DateTime("2020-01-06 00:00:00"));

        //user tireur
        $tireurf = new user();
        $tireurf->setUsername('Tireuf');
        $tireurf->setNom('Tireuf');
        $tireurf->setPrenom('Tireuf');
        $tireurf->setPassword($this->passwordEncoder->encodePassword($adminf,'azerty'));
        $tireurf->setRole('ROLE_TIREUR');
        $tireurf->setGenre('homme');
        $tireurf->setArbitre($arbitref);
        $tireurf->setBlason('Jaune');
        $tireurf->setCreatedAt( new \DateTime("2020-01-06 00:00:00"));
        $tireurf->setGroupe($fgroupe);
        $tireurf->setCategorieAge('Seniors');
        $tireurf->setArme($armef);

        //user maitre d'armes
        $maitref = new user();
        $maitref->setUsername('Maitref');
        $maitref->setPassword($this->passwordEncoder->encodePassword($adminf,'azerty'));
        $maitref->setRole('ROLE_MAITRE');
        $maitref->setGenre('homme');
        $maitref->setArbitre($arbitref);
        $maitref->setBlason('Jaune');
        $maitref->setCreatedAt( new \DateTime("2020-01-06 00:00:00"));
        $maitref->setGroupe($fgroupe);
        $maitref->setCategorieAge('Seniors');
        $maitref->setArme($armef);

        
        


        $manager->persist($fgroupe);
        $manager->persist($arbitref);
        $manager->persist($armef);
        $manager->persist($adminf);
        $manager->persist($tireurf);
        $manager->persist($maitref);

        $manager->flush();
    }
}
