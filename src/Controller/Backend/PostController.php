<?php

namespace App\Controller\Backend;


use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;


/**
 * 
 * @Route("/backend", name="backend_")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="adList")
     */
    public function adList(PostRepository $postRepository)
    {
        $adPosts= $postRepository->findAllAdPost();
        return $this->render('backend/post/adList.html.twig', [
            'adPosts' => $adPosts
        ]);
    }

    /**
     * @Route("/articles", name="advicePostList")
     */
    public function advicePostList(PostRepository $postRepository)
    {
        $advicePosts= $postRepository->findAllAdvicePost();
        return $this->render('backend/post/advicePostList.html.twig', [
            'advicePosts' => $advicePosts
           
        ]);
    }

    // Création d'un article de conseil sur page d'accueil
    /**
     * @Route("/advice-post/new/", name="advicePostNew")
     */
    public function advicePostNew(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager -> persist($post);
            $entityManager -> flush();
            return $this->redirectToRoute('backend_advicePostList');
        }
       return $this->render('backend/post/advicePostNew.html.twig', [
           'form' => $form->createView(),
       ]);

    }

    
    /**
     * @Route("/post/edit/{id}", name="advicePostEdit", methods="GET|POST")
     */
    public function advicePostEdit(Request $request, Post $post) 
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Article modifié.');
            return $this->redirectToRoute('backend_advicePostEdit', ['id' => $post->getId()]);
        }
        return $this->render('backend/post/advicePostEdit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/post/delete/{id}", name="advicePostDelete", methods="DELETE", requirements={"id"="\d+"})
     */
    public function advicePostDelete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
            $this->addFlash('success', 'Article supprimé.');
        }
        return $this->redirectToRoute('backend_advicePostList');
    }

    
}
