<?php

namespace App\Controller;

use App\Entity\UserObjectifs;
use App\Form\UserObjectifsType;
use App\Repository\UserObjectifsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/objectifs")
 */
class UserObjectifsController extends AbstractController
{
    /**
     * @Route("/", name="user_objectifs_index", methods={"GET"})
     */
    public function index(UserObjectifsRepository $userObjectifsRepository): Response
    {
        return $this->render('user_objectifs/index.html.twig', [
            'user_objectifs' => $userObjectifsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_objectifs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userObjectif = new UserObjectifs();
        $form = $this->createForm(UserObjectifsType::class, $userObjectif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userObjectif);
            $entityManager->flush();

            return $this->redirectToRoute('user_objectifs_index');
        }

        return $this->render('user_objectifs/new.html.twig', [
            'user_objectif' => $userObjectif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_objectifs_show", methods={"GET"})
     */
    public function show(UserObjectifs $userObjectif): Response
    {
        return $this->render('user_objectifs/show.html.twig', [
            'user_objectif' => $userObjectif,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_objectifs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserObjectifs $userObjectif): Response
    {
        $form = $this->createForm(UserObjectifsType::class, $userObjectif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_objectifs_index', [
                'id' => $userObjectif->getId(),
            ]);
        }

        return $this->render('user_objectifs/edit.html.twig', [
            'user_objectif' => $userObjectif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_objectifs_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserObjectifs $userObjectif): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userObjectif->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userObjectif);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_objectifs_index');
    }
}
