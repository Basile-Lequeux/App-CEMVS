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
use App\Form\MaitreLeconType;



/**
 * @Route("/")
 * @Security("is_granted(['ROLE_ADMIN','ROLE_TIREUR','ROLE_MAITRE'])")
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

        /**
        * @Route("/leconMaitre", name = "leconMaitre", methods={"GET","POST"})
        * @Security("is_granted(['ROLE_MAITRE'])")
        */
        public function leconMaitre(Request $request, ObjectManager $manager)
        
        {
            $leconsDonnees = $manager->getRepository(Lecon::class)->findBy(['maitreArme'=>$this->getUser()]);
            $lecons = $manager->getRepository(Lecon::class)->findAll();

            

            return $this->render('lecon/leconMaitre.html.twig',[
                'leconsDonnees' => $leconsDonnees,
                'lecons' => $lecons,
                
             ]);
        }



        /**
        * @Route("/newLeconMaitre", name = "new_leconMaitre", methods={"GET","POST"})
        * @Security("is_granted(['ROLE_MAITRE'])")
        */
        public function newLeconMaitre(Request $request, ObjectManager $manager)
        
        {
            $lecon = new Lecon();


            $entrainements = $manager->getRepository(Entrainement::class)->getEntrainementPasse($manager);
            $userG = $manager->getRepository(User::class);
            $tireurs = $userG->getTireur($userG);

            $lecon->setListeTireur($tireurs);
            $lecon->setListeEntrainement($entrainements);
            
            $form = $this->createForm(MaitreLeconType::class, $lecon);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) 
            {
                
                $lecon->setEntrainement($form->getViewData()->getListeEntrainement());
                $lecon->setMaitreArme($this->getUser());
                $lecon->setUser($form->getViewData()->getListeTireur());
                $lecon->setPresent(true);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($lecon);
                $manager->flush();

                return $this->redirectToRoute('leconMaitre');

            }

            return $this->render('lecon/newLeconMaitre.html.twig', [
                'form' => $form->createView(),
            ]);
        }

     



    

}
