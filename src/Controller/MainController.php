<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Lecon;
use App\Form\LeconType;
use App\Entity\Competitions;
use App\Entity\Entrainement;
use App\Actions\ActionsProject;
use App\Entity\CompetitionsUser;
use App\Entity\EntrainementUser;
use App\Form\CompetitionsUserType;
use App\Form\EntrainementUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request, ObjectManager $manager)
    {
        $manager->getRepository(Entrainement::class);
        $actionsProject = new ActionsProject();
        $entrainement = $actionsProject->compareDateEntrainement($manager);
        if(!$entrainement){
            $entrainement[0] = false;
        }else{
            $tableUser = array();
            foreach($entrainement[0]->getGroupes() as $groupe)
            {
                foreach($groupe->getUsers() as $user){
                    array_push($tableUser, $user);
                }
            }
            $entrainementUser= new EntrainementUser();
            $form = $this->createForm(EntrainementUserType::class, $entrainementUser,array(
                'users' => $tableUser,
            ));
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entrainementUser->setEntrainements($entrainement[0]);
                $entrainementUser->setPresent(true);
                $manager->persist($entrainementUser);
                $manager->flush();
                return $this->redirectToRoute('main');
            }
            $leconEntrainement = new Lecon();
            $userG= $manager->getRepository(User::class);
            $userMaitreArmes = $actionsProject->getMaitreArmes($userG);
            $formLecon = $this->createForm(LeconType::class, $leconEntrainement, array(
                'maitreArmes' => $userMaitreArmes,
            ));
            $formLecon->handleRequest($request);
            //Insertion Lecon
            if($formLecon->isSubmitted() && $formLecon->isValid()){

                $leconEntrainement->setMaitreArme($leconEntrainement->getRawMaitre()->getId());
                $leconEntrainement->setEntrainement($entrainement[0]);
                $leconEntrainement->setUser($this->getUser());
                $leconEntrainement->setPresent(true);
                $manager->persist($leconEntrainement);
                $manager->flush();
                $this->addFlash('success','Enregistrement de la leçon réussie');
                return $this->redirectToRoute('main');
            }
            return $this->render('main/index.html.twig',[
                "entrainement" => $entrainement[0],
                "form" => $form->createView(),
                "formLecon" => $formLecon->createView(),
            ]);
        }
        return $this->render('main/index.html.twig',[
            "entrainement" => $entrainement[0],
        ]);
        
    }

    /**
     * @Route("/listCompetitions", name="list_competitions")
     * @Security("is_granted(['ROLE_ADMIN','ROLE_TIREUR','ROLE_MAITRE'])")
     */
    public function listCompetitions(Request $request, ObjectManager $manager){

        $competitions = $manager->getRepository(Competitions::class)->findAll();

        $competitionUser = new CompetitionsUser();
        $form = $this->createForm(CompetitionsUserType::class, $competitionUser);
        $form->handleRequest($request);
        // Inscription compétition
        if($form->isSubmitted() && $form->isValid()){
            $competitionUser->setUser($this->getUser());

            $competitionUser->getCompetition()->setParticipants($competitionUser->getCompetition()->getParticipants()+1);
            $manager->persist($competitionUser);
            $manager->flush();
            $this->addFlash('succes','Vous vous êtes bien inscrit à une compétition');
            return $this->redirectToRoute("list_competitions");
        }

        return $this->render('main/listCompetitions.html.twig',[
            'competitions' => $competitions,
         ]);
    }
    /**
     * @Route("/mesCompetitions", name="mes_competitions")
     * @Security("is_granted(['ROLE_ADMIN','ROLE_TIREUR','ROLE_MAITRE'])")
     */
    public function mesCompetitions(Request $request, ObjectManager $manager){
        
        $actions = new ActionsProject();
        $element = $manager->getRepository(Competitions::class);
        $competitionsRevolues = $actions->getCompetitionsRevolues($element,$this->getUser());
        $tableauCompetitionUser = array();

        //$val = array($competitionsRevolues[0]->getUsers());

        for($i=0; $i<sizeof($competitionsRevolues); $i++){
            $val = $competitionsRevolues[$i]->getUsers();
            if(sizeof($val)){
                if($val[$i]->getUser()->getUsername() == $this->getUser()->getUsername()){
                    array_push($tableauCompetitionUser,$competitionsRevolues[$i]);
                }
            }else{
                $tableauCompetitionUser = false ;
            }
        }
        

        return $this->render('main/mesCompetitions.html.twig',[
            'competitions' => $tableauCompetitionUser,
         ]);
    }
    /**
     * @Route("/mesCompetitions/{id}", name="mes_competitions_view")
     * @Security("is_granted(['ROLE_ADMIN','ROLE_TIREUR'])")
     */
    public function mesCompetitionsView(Request $request, ObjectManager $manager, $id){
        $competition = $manager->getRepository(CompetitionsUser::class)->findOneBy(['competition'=> $id]);
        $form = $this->createForm(CompetitionsUserType::class, $competition, array(
            'update'=>true,
        ));
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($competition->getPlace() < $competition->getCompetition()->getParticipants()){
                $manager->persist($competition);
                $manager->flush();
                return $this->redirectToRoute("mes_competitions");
            }else{
                $this->addFlash('danger','Votre place ne correspond pas au nombre de participants');
            }
        }
        return $this->render('main/mesCompetitions_view.html.twig',[
            'competition' => $competition,
            'form' => $form->createView(),
         ]);
    }

    /**
     * @Route("/mesLecons", name="mes_lecons")
     * @Security("is_granted(['ROLE_ADMIN','ROLE_TIREUR'])")
     */
    public function mesLecons(Request $request, ObjectManager $manager){
        $lecons = $manager->getRepository(Lecon::class)->findBy(['user'=>$this->getUser()]);

        return $this->render('main/mesLecons.html.twig',[
            'lecons' => $lecons,
         ]);
    }
}

