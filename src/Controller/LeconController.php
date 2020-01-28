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



/**
 * @Route("/")
 * @Security("is_granted(['ROLE_ADMIN','ROLE_TIREUR'])")
 */
class LeconController extends AbstractController
{
    /**
     * @Route("/mesLecons", name="mes_lecons")
     */
    public function mesLecons(Request $request, ObjectManager $manager){
        $lecons = $manager->getRepository(Lecon::class)->findBy(['user'=>$this->getUser()]);
        $entrainementsPresent = $manager->getRepository(EntrainementUser::class)->findBy(['user'=>$this->getUser()]);
        
        $sansLecon = array();
        $avecLecon =array();

        foreach ($entrainementsPresent as $e) 
        {

            array_push($sansLecon, $e->getEntrainements());

        }
       
        foreach($lecons as $l)
        { 
            array_push($avecLecon, $l->getentrainement());
        }
       

        
        return $this->render('lecon/mesLecons.html.twig',[
            'lecons' => $lecons,
            'entrainements' => array_diff($sansLecon, $avecLecon),
         ]);
    }



    /**
     * @Route("/new", name="new_lecon", methods={"GET","POST"})
     */
    public function new(Request $request, ObjectManager $manager)
    {
        
        $leconEntrainement = new Lecon();
        $userG = $manager->getRepository(User::class);
        $userMaitreArmes = $userG->getMaitreArmes($userG);
        $formLecon = $this->createForm(LeconType::class, $leconEntrainement, array(
            'maitreArmes' => $userMaitreArmes,
        ));
        $formLecon->handleRequest($request);
        $entrainement = $manager->getRepository(Entrainement::class)->findOneBy(['id'=>$request->query->get('id')]);

        if($formLecon->isSubmitted() && $formLecon->isValid()){

            $leconEntrainement->setMaitreArme($formLecon->getViewData()->getRawMaitre());
            $leconEntrainement->setEntrainement($entrainement);
            $leconEntrainement->setUser($this->getUser());
            $leconEntrainement->setPresent(true);
            $manager->persist($leconEntrainement);
            $manager->flush();
            $this->addFlash('success','Enregistrement de la leçon réussie');
            return $this->redirectToRoute('mes_lecons');
        }
        return $this->render('lecon/new.html.twig',[

            "form" => $formLecon->createView(),

        ]);

    

     
    }

}
