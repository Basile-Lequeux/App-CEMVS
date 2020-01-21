<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion(AuthenticationUtils $authentificationUtils)
    {
        $lastUsername = $authentificationUtils->getLastUsername();
        $error = $authentificationUtils->getLastAuthenticationError();
        
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    /**
     * @Route("/inscription", methods={"GET","POST"}, name="inscription")
     * @Security("is_granted('ROLE_ADMIN') ")
     */
    public function signup(Request $request, UserPasswordEncoderInterface $encoder)
    {
       
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($user, $user->getRawPassword());
            $user->setPassword($encoded);
            $user->setCreatedAt(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('users_index');
        }
        return $this->render('security/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/edit/{id}", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_index');
            
        }
        return $this->render('Security/signup.html.twig', [
            
            'form' => $form->createView(),
        ]);
    }


}
