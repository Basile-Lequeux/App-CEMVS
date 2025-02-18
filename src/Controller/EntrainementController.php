<?php

namespace App\Controller;

use App\Entity\Entrainement;
use App\Form\EntrainementType;
use App\Repository\EntrainementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/entrainement")
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_MAITRE')")
 */
class EntrainementController extends AbstractController
{
    /**
     * @Route("/", name="entrainement_index", methods={"GET"})
     */
    public function index(EntrainementRepository $entrainementRepository): Response
    {
        return $this->render('entrainement/index.html.twig', [
            'entrainements' => $entrainementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entrainement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entrainement = new Entrainement();
        $form = $this->createForm(EntrainementType::class, $entrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach($entrainement->getGroupes() as $groupe){
                $groupe->addEntrainement($entrainement);
                
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entrainement);
            $entityManager->flush();

            return $this->redirectToRoute('entrainement_index');
        }

        return $this->render('entrainement/new.html.twig', [
            'entrainement' => $entrainement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entrainement_show", methods={"GET"})
     */
    public function show(Entrainement $entrainement): Response
    {
        return $this->render('entrainement/show.html.twig', [
            'entrainement' => $entrainement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entrainement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entrainement $entrainement): Response
    {
        $form = $this->createForm(EntrainementType::class, $entrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            foreach($entrainement->getGroupes() as $groupe){
                $groupe->addEntrainement($entrainement);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entrainement_index', [
                'id' => $entrainement->getId(),
            ]);
        }

        return $this->render('entrainement/edit.html.twig', [
            'entrainement' => $entrainement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entrainement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entrainement $entrainement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrainement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entrainement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entrainement_index');
    }
}
