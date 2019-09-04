<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    /**
     * @Route("/tag", name="tag")
     */
    public function index()
    {
        return $this->render('tag/index.html.twig', [
            'controller_name' => 'TagController',
        ]);
    }

    /**
     * @Route("/tag/new", name="tag_new")
     */
    public function new(Request $request)
    {
        $tag = new Tag();
        $form = $this->createForm(TagTyJpe::class, $tag);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager -> persist($tag);
            $entityManager -> flush();
            return $this->redirectToRoute('tag_new');
        }
       return $this->render('tag/newTag.html.twig', [
           'form' => $form->createView(),
       ]);
    }
}
