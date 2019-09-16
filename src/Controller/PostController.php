<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Post;
use App\Form\JobType;
use App\Form\PostType;
use App\Utils\Slugger;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\UserSearchType;
use App\Repository\JobRepository;
use App\Repository\TagRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\StatusRepository;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * Page d'accueil visiteur avec la liste des ARTICLES DE CONSEILS :
     * 
     * @Route("/", name="advice_post", methods={"GET"})
     */
    public function advicePostList(PostRepository $postRepository)
    {
        $advicePosts = $postRepository->findBy(array(), array('createdAt' => 'DESC'));
        $advicePosts = $postRepository->findAllAdvicePost();

        return $this->render('post/advice_post/index.html.twig', [
            'advicePosts' => $advicePosts
        ]);
    }

    /**
     * Page d'accueil utilisateur (après inscription/connexion) avec la liste des ANNONCES :
     * 
     * @Route("/annonces", name="ad_post")
     */
    public function adList(PostRepository $postRepository, TagRepository $tagRepository)
    {
       
            $posts = $postRepository->findAllAdPost(array(), array('createdAt' => 'DESC'));
            
        
            $tags = $tagRepository->findAll();
        

        return $this->render('post/ad_post/index.html.twig', [
            'posts' => $posts,
            'tags' => $tags
         
        ]);
    }



    /**
     * Page de détail d'un ARTICLE DE CONSEILS (pas de possibilité de commenter) :
     *
     * @Route("/advicepost/{slug}", name="advice_post_show", methods={"GET","POST"})
     */
    public function advicePostShow(Post $advicePost, Request $request, UserRepository $userRepository, CommentRepository $commentRepository, Slugger $slugger)
    {

        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $comment->setPost($advicePost);
            $user = $userRepository->findOneByUsername('emoen');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('advice_post_show', ['slug' => $advicePost->getSlug()]);
        }
        return $this->render('post/advice_post/show.html.twig', [
            'advicePost' => $advicePost,
            'formComment' => $formComment->createView(),
        ]);
    }

    /**
     * Page de de détail d'une ANNONCE avec formulaire pour poster un commentaire (pour les utilisateurs exclusivement) :
     * 
     * @Route("/annonce/{slug}", name="ad_post_show", methods={"GET","POST"})
     */
    public function adPostShow(Post $post, Request $request, StatusRepository $statusRepository, Slugger $slugger)
    { 

        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);
        $user = $this->getUser();
        $defaultStatus = 'UNBLOCKED';
        $unblockedStatus = $statusRepository->findOneByCode($defaultStatus);


        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $comment->setPost($post);
            $comment->setUser($user);
            $comment->setStatus($unblockedStatus);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre commentaire a bien été enregistré !'
            );

            return $this->redirectToRoute('ad_post_show', ['slug' => $post->getSlug()]);
        }
        return $this->render('post/ad_post/show.html.twig', [
            'post' => $post,
            'formComment' => $formComment->createView(),
        ]);
    }

    // ANNONCES *****************************************************************************************

    /**
     * Page formulaire d'ajout d'une ANNONCE (pour les utilisateurs exclusivement)
     *
     * @Route("/annonces/new", name="ad_post_new", methods={"GET","POST"})
     */
    public function adNew(Request $request, StatusRepository $statusRepository): Response
    {
        $statusCode = 'UNBLOCKED';
        $statusCode = $statusRepository->findOneByCode($statusCode);
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $post->setStatus($statusCode);
            $post->setType('Annonce');
            $post->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre annonce a bien été enregistrée !'
            );

            return $this->redirectToRoute('ad_post');
        }
        return $this->render('post/ad_post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    public function adPostsNavList(PostRepository $postRepository){

        // Classés du plus récent au moins récent
        $adPosts = $postRepository->findBy(array(), array('createdAt' => 'DESC'));
        return $this->render('post/ad_post/adPostsNavList.html.twig', [
           'adPosts' => $adPosts,
       ]);
    }
}
