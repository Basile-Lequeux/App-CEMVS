<?php

namespace App\Controller;

use App\Entity\Competitions;
use App\Entity\CompetitionsUser;
use App\Form\CompetitionsType;
use App\Form\CompetitionsUserType;
use App\Repository\CompetitionsRepository;
use App\Repository\CompetitionsUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/competitions")
 * @Security("is_granted(['ROLE_ADMIN','ROLE_TIREUR','ROLE_MAITRE'])")
 */
class CompetitionsController extends AbstractController
{
    /**
     * @Route("/", name="competitions_index", methods={"GET"})
     */
    public function index(CompetitionsRepository $competitionsRepository): Response
    {
        return $this->render('competitions/index.html.twig', [
            'competitions' => $competitionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="competitions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $competition = new Competitions();
        $form = $this->createForm(CompetitionsType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competition->setParticipants(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competition);
            $entityManager->flush();

            return $this->redirectToRoute('competitions_index');
        }

        return $this->render('competitions/new.html.twig', [
            'competition' => $competition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competitions_show", methods={"GET"})
     */
    public function show(Competitions $competition): Response
    {
        return $this->render('competitions/show.html.twig', [
            'competition' => $competition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="competitions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Competitions $competition): Response
    {
        $form = $this->createForm(CompetitionsType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('competitions_index', [
                'id' => $competition->getId(),
            ]);
        }

        return $this->render('competitions/edit.html.twig', [
            'competition' => $competition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competitions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Competitions $competition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($competition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('competitions_index');
    }






}
