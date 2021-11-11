<?php

namespace App\Controller;

use App\Entity\Argonaute;
use App\Form\ArgonauteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/")
 */
class ArgonauteController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="argonaute")
     */
    public function index(Request $request): Response
    {
        $argonautes = $this->em->getRepository(Argonaute::class)->findAll();

        // formulaire
        $argonaute = new Argonaute;

        $addArgonauteForm = $this->createForm(ArgonauteType::class, $argonaute);
        $addArgonauteForm->handleRequest($request);

        if ($addArgonauteForm->isSubmitted() && $addArgonauteForm->isValid()) {
            $argonaute = $addArgonauteForm->getData();
            $this->em->persist($argonaute);
            $this->em->flush();
            return $this->redirectToRoute("argonaute");
        }

        return $this->render('argonaute/index.html.twig', [
            'argonautes' => $argonautes,
            'addArgonauteForm' => $addArgonauteForm->createView(),
        ]);
    }

    /**
     * @Route("/modify/{id}", name="modify_argonaute")
     */
    public function modify(Argonaute $id, Request $request): Response
    {
        $updateArgonauteForm = $this->createForm(ArgonauteType::class, $id);
        $updateArgonauteForm->handleRequest($request);
        if ($updateArgonauteForm->isSubmitted() && $updateArgonauteForm->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute("argonaute");
        }
        return $this->render('argonaute/modify.html.twig', [
            'modify_argonaute_form' => $updateArgonauteForm->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_argonaute")
     */
    public function delete(Argonaute $id)
    {
        $this->em->remove($id);
        $this->em->flush();
        return $this->redirectToRoute('argonaute');
    }
}
