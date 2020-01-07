<?php

namespace App\Actions;

use App\Entity\Competitions;
use App\Entity\Entrainement;
use App\Entity\CompetitionsUser;
use App\Entity\EntrainementUser;


class ActionsPerformance{

    public function getPerfCompetition($manager,$users){
        $competitions = $manager->getRepository(CompetitionsUser::class)->findBy(['user'=>$users]);
        $tabPerfCompetitions = array();
        $tabPlace = array();
        $tabParticipants = array();
        foreach($competitions as $competition){
            array_push($tabPerfCompetitions, [$competition->getPlace(),$competition->getCompetition()->getParticipants(), $competition->getCompetition()->getId()]);
        }

        return $tabPerfCompetitions;
    }

    public function getEngagement($manager, $users){
        $tableEngagement = array();
        $countParticpation = 0;
        $countTotal = 0;

        $competitionsparticipations = $manager->getRepository(CompetitionsUser::class)->findBy(['user'=>$users]);
        $countParticpation = sizeof($competitionsparticipations);

        $competitionsTotal = $manager->getRepository(Competitions::class)->findBy(['categorieAge' => $users->getCategorieAge()]);
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