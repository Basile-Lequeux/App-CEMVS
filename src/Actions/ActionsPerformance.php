<?php

namespace App\Actions;

use App\Entity\Competitions;
use App\Entity\Entrainement;
use App\Entity\CompetitionsUser;
use App\Entity\EntrainementUser;


class ActionsPerformance{

    public function getPerfCompetition($manager,$user){

        // les competitions Tirées par le tireur
        $competitionsparticipations = $manager->getRepository(CompetitionsUser::class)->getCompetitionTireur($user); 
        // dump($competitionsparticipations);
        // Le nombre de compétitions passées de la categorie du Tireur (si il est surclassé seulement la catégorie la plus basse est prise en compte)
        $competitionsTotal = $manager->getRepository(Competitions::class)->getCompetitionsRevoluesByCategorie($user->getCategorieAge()[0]); 
       
        

        $mParticipants = 0; //moyenne du nombre de participants
        $mPlace = 0; // moyenne de la place du tireur 
        $i = 0; // somme des compétitions prise en compte

        foreach($competitionsparticipations as $competition){
            
            if ($competition->getplace() != null)
            {
                $i += 1;
                $mParticipants += $competition->getCompetition()->getParticipants(); //somme des partcipants
                $mPlace += $competition->getPlace(); // somme des tireurs
                
            }

            }

            if ($i == 0) 
            {
                return 0;    
            }
            else 
            {
                $mParticipants = $mParticipants / $i; //moyenne
                $mPlace = $mPlace / $i; //moyenne
                $assiduite = count($competitionsparticipations) / count($competitionsTotal);
                
                return ($mParticipants / $mPlace ) * $assiduite;
            }
    }

    public function getEngagement($manager, $users){
        $tableEngagement = array();
        $countParticpation = 0;
        $countTotal = 0;


        

        $competitionsparticipations = $manager->getRepository(CompetitionsUser::class)->findBy(['user'=>$users]);
        $countParticpation = sizeof($competitionsparticipations);
        foreach ($users->getCategorieAge() as $c) 
        {
            
            $competitionsTotal = $manager->getRepository(Competitions::class)->findBy(['CategorieAge' => $c]);
            array_push($competitionsTotal, $c);
        }
        
        $countTotal = sizeof($competitionsTotal);

        array_push($tableEngagement,[$countParticpation,$countTotal]);

        return $tableEngagement;
    }

    public function getAssiduite($manager, $users){
        $tableAssiduite = array();
        $countTotal = 0;
        $countParticpation = 0;
        $entrainementsPresent = $manager->getRepository(EntrainementUser::class)->findBy(['user'=>$users]);
        $countParticpation = sizeof($entrainementsPresent);
        $entrainementsTotaux = $manager->getRepository(Entrainement::class)->findAll();
        foreach($entrainementsTotaux as $entrainementTotaux){
            foreach($entrainementTotaux->getGroupes() as $groupe){
                foreach($groupe->getUsers() as $user){
                    if($user == $users){
                        //array_push($tabTotal,$entrainementTotaux);
                        $countTotal++;
                    }
                }
            }
        }
        array_push($tableAssiduite,[$countParticpation,$countTotal]);

        return $tableAssiduite;
    }
}