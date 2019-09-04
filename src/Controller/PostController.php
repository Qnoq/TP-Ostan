<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * Page d'accueil visiteur avec la liste des articles conseils :
     * 
     * @Route("/", name="advice_post", methods={"GET"})
     */
    public function index(PostRepository $PostRepository)
    {
        $advicePosts = $PostRepository->findBy(array(), array('createdAt' => 'DESC'));
        return $this->render('post/advice_post/index.html.twig', [
            'advicePosts' => $advicePosts
        ]);
    }
    /**
     * Page de détail d'un article de conseils :
     *
     * @Route("/advicepost/{id}", name="advice_post_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show()
    {
        return $this->render('post/advice_post/show.html.twig');
    }





// ANNONCES *****************************************************************************************

     /**
     * @Route("/annonce/new", name="adNew")
     */
    public function adNew(Request $request)
    {
        
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $post->setType('Annonce');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager -> persist($post);
            $entityManager -> flush();
            return $this->redirectToRoute('advice_post');
        }
       return $this->render('post/ad_post/adAdd.html.twig', [
           'form' => $form->createView(),
       ]);
    }
}
