<?php

namespace App\Controller;

use App\Entity\Competitions;
use App\Entity\User;
use App\Actions\ActionsPerformance;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PerformanceController extends AbstractController
{
    /**
     * @Route("/performances", name="mes_performances")
     * @Security("is_granted(['ROLE_ADMIN','ROLE_TIREUR','ROLE_MAITRE'])")
     */
    public function index(ObjectManager $manager)
    {
        $perfActions = new ActionsPerformance();
        

        $userG = $manager->getRepository(User::class);
        $listeTireur = $userG->GetTireur($userG);
        $moyennePerf = 0;
        $totalTireur = 0;
        

        foreach ($listeTireur as $tireur) 
        {
            $performance = $perfActions->getPerfCompetition($manager, $tireur);
            
            if ($performance != 0 and $performance != null) 
            {
                $totalTireur += 1;  
                $moyennePerf = $moyennePerf + round($performance, 2);
            }
            dump($totalTireur);
           dump($moyennePerf);
        }
        $moyennePerf = $moyennePerf / $totalTireur;
        
        $perfCompetitions = array();

        array_push($perfCompetitions, round($perfActions->getPerfCompetition($manager, $this->getUser()), 2), round($moyennePerf, 2));

        $engagement = $perfActions->getEngagement($manager, $this->getUser());
        $assiduite = $perfActions->getAssiduite($manager, $this->getUser());

        return $this->render('performance/index.html.twig', [
            'perfCompetitions' => $perfCompetitions,
            'engagement' => $engagement,
            'assiduite' => $assiduite,
        ]);
    }
}
