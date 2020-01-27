<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Lecon;
use App\Form\LeconType;
use App\Entity\Competitions;
use App\Entity\Entrainement;
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
use Doctrine\Common\Collections\Collection;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request, ObjectManager $manager)
    {
        //$manager->getRepository(Entrainement::class);
       
        $entrainement = $manager->getRepository(Entrainement::class)->compareDateEntrainement($manager);
        if(!$entrainement){
            $entrainement[0] = false;
        }else{
            $tableUser = array();
            $tableGroupe = array();
            $tablePresent = array();

            foreach ($entrainement[0]->getUsers() as $userE) 
            {
                $userarray = array($userE->getUser());// Convertion de l'objet en tableau afin de pouvour le comparer à $tableGroupe qui retrounera Une Collection de User donc un tableau
            
                array_push($tablePresent, $userarray[0]);                                     
            }
                   
             
            foreach($entrainement[0]->getGroupes() as $groupe)
            {
                foreach($groupe->getUsers() as $user){
                
                array_push($tableGroupe, $user);
                                                                                                                                         
                }
            } $tableUser = array_diff($tableGroupe, $tablePresent);

            $entrainementUser= new EntrainementUser();
            $form = $this->createForm(EntrainementUserType::class, $entrainementUser,array(
                'users' => $tableUser,
            ));
            $form->handleRequest($request);
         

            if ($form->isSubmitted() && $form->isValid()){
                $entrainementUser->setEntrainements($entrainement[0]);
                $entrainementUser->setPresent(true);
                $manager->persist($entrainementUser);
                $manager->flush();
                return $this->redirectToRoute('main');
            }
            $leconEntrainement = new Lecon();
            $userG= $manager->getRepository(User::class);
            $userMaitreArmes = $userG->getMaitreArmes($userG);
            $formLecon = $this->createForm(LeconType::class, $leconEntrainement, array(
                'maitreArmes' => $userMaitreArmes,
            ));
            $formLecon->handleRequest($request);
            //Insertion Lecon
            if($formLecon->isSubmitted() && $formLecon->isValid()){

                $leconEntrainement->setMaitreArme($formLecon->getViewData()->getRawMaitre());
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
        // $compet = $manager->getRepository(Competitions::class)->getTireur($this->getUser()->getCompetitions());
        
        $competitionUser = new CompetitionsUser();
        $form = $this->createForm(CompetitionsUserType::class, $competitionUser);
        $form->handleRequest($request);
        // Inscription compétition
        if($form->isSubmitted() && $form->isValid()){
            $competitionUser->setUser($this->getUser());

            // $competitionUser->getCompetition()->setParticipants($competitionUser->getCompetition()->getParticipants()+1);
            $manager->persist($competitionUser);
            $manager->flush();
            $this->addFlash('succes','Vous vous êtes bien inscrit à une compétition');
            return $this->redirectToRoute("list_competitions");
        }

        $tableCompetitionInscrit = array();

        for ($i=0; $i <sizeof($competitions) ; $i++) 
        { 
             foreach($competitions[$i]->getUsers() as $val)
            {

                if ($val->getUser() == $this->getUser()) 
                {           
                    array_push($tableCompetitionInscrit, $competitions[$i]);
                }
              
        
            }
        }
        $test = array();
        for ($i=0; $i <sizeof($competitions) ; $i++) 
        { 
             foreach($competitions[$i]->getUsers() as $val)
            {
                

                if ($val->getUser() == $this->getUser()) 
                {           
                    array_push($test, $val->getid());
                }
              
        
            }
        }


        $tableCategorieUser = array();

        
        foreach ($this->getUser()->getCategorieAge() as $c) 
        {
            array_push($tableCategorieUser, $c->getlibelle());
        }
        
        

        
    
        return $this->render('main/listCompetitions.html.twig',[
            'competitions' => array_diff($competitions, $tableCompetitionInscrit),
            'competitionInscrit' => $tableCompetitionInscrit,
            'test' => $test,
            'categorieUser' => $tableCategorieUser,
            
            
            
         ]);
    }
    /**
     * @Route("/mesCompetitions", name="mes_competitions")
     * @Security("is_granted(['ROLE_ADMIN','ROLE_TIREUR','ROLE_MAITRE'])")
     */
    public function mesCompetitions(Request $request, ObjectManager $manager){
        
       
        $element = $manager->getRepository(Competitions::class);
        $competitionsRevolues = $element->getCompetitionsRevolues($element);
        $tableauCompetitionUser = array();
        

        // $val = array($competitionsRevolues[0]->getUsers());

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
     * @Route("/desinscrire/{id}", name="competitions_desinscrire", methods={"DELETE"})
     */

    public function desinscrire(Request $request, CompetitionsUser $competitionUser)
    {
        if ($this->isCsrfTokenValid('delete'.$competitionUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($competitionUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute("list_competitions");
    }







}

