<?php

namespace App\Controller;

use App\Entity\UserArme;
use App\Form\UserArmeType;
use App\Repository\UserArmeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user/arme")
 * @Security("is_granted('ROLE_ADMIN') ")
 */
class UserArmeController extends AbstractController
{
    /**
     * @Route("/", name="user_arme_index", methods={"GET"})
     */
    public function index(UserArmeRepository $userArmeRepository): Response
    {
        return $this->render('user_arme/index.html.twig', [
            'user_armes' => $userArmeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_arme_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userArme = new UserArme();
        $form = $this->createForm(UserArmeType::class, $userArme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userArme);
            $entityManager->flush();

            return $this->redirectToRoute('user_arme_index');
        }

        return $this->render('user_arme/new.html.twig', [
            'user_arme' => $userArme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_arme_show", methods={"GET"})
     */
    public function show(UserArme $userArme): Response
    {
        return $this->render('user_arme/show.html.twig', [
            'user_arme' => $userArme,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_arme_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserArme $userArme): Response
    {
        $form = $this->createForm(UserArmeType::class, $userArme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_arme_index', [
                'id' => $userArme->getId(),
            ]);
        }

        return $this->render('user_arme/edit.html.twig', [
            'user_arme' => $userArme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_arme_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserArme $userArme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userArme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userArme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_arme_index');
    }
}
