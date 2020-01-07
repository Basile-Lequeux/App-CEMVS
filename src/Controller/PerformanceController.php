<?php

namespace App\Controller;

use App\Entity\Competitions;
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
        $perfCompetitions = $perfActions->getPerfCompetition($manager, $this->getUser());
        $engagement = $perfActions->getEngagement($manager, $this->getUser());
        $assiduite = $perfActions->getAssiduite($manager, $this->getUser());

        return $this->render('performance/index.html.twig', [
            'perfCompetitions' => $perfCompetitions,
            'engagement' => $engagement,
            'assiduite' => $assiduite,
        ]);
    }
}
