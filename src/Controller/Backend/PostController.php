<?php

namespace App\Controller\Backend;


use App\Entity\Post;
use App\Form\PostType;
use App\Utils\Slugger;
use App\Form\PostSearchType;
use App\Repository\PostRepository;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * 
 * @Route("/backend", name="backend_")
 */
class PostController extends AbstractController
{

    /**
     * LISTE DES ANNONCES + FILTRE/RECHERCHE PAR UTILISATEUR/JOB
     * @Route("/", name="adList")
     */
    public function adList(PostRepository $postRepository, UserRepository $userRepository, Request $request)
    {
        $formSearchPost = $this->createForm(PostSearchType::class);

        $formSearchPost->handleRequest($request);
        if ($formSearchPost->isSubmitted() && $formSearchPost->isValid()) {
            $formTitle = $formSearchPost->getTitle();
            $criterias = $request->request->get($formTitle);

            $users = $userRepository->searchHome($criterias);

            //dump($criterias);
            //dump($formTitle);
            //dump($users);

        } else {
            
            // Classés par date de création, du plus récent au plus ancien
            //$users = $userRepository->findBy(array(), array('name' => 'ASC'));
            $postsearch = $postRepository->findBy(array(), array('createdAt' => 'DESC'));
            
        }

        $posts = $postRepository->findAllAdPost();
        return $this->render('backend/post/adList.html.twig', [
            //'users' => $users,
            'postsearch' => $postsearch,
            'posts' => $posts,
            //'formSearchPost' => $formSearchPost->createView(),
        ]);
    }


    public function postSearchForm(Request $request, PostRepository $postRepository){

        $formSearchPost = $this->createForm(PostSearchType::class);
        $formSearchPost->handleRequest($request);
    
        return $this->render('backend/post/adListForm.html.twig', [
            'formSearchPost' => $formSearchPost->createView(),
        ]);
     }



    public function postNavList(PostRepository $postRepository){

        // Classés du plus récent au moins récent
        $postsearch = $postRepository->findBy(array(), array('createdAt' => 'DESC'));
        return $this->render('backend/post/adListSearch.html.twig', [
            'postsearch' => $postsearch,
       ]);
    }

   /* FIN RECHERCHE */


    /**
     * @Route("/articles", name="advicePostList")
     */
    public function advicePostList(PostRepository $postRepository, Request $request)
    {
        $db = $this->getDoctrine()->getManager();

        $listPost = $db->getRepository('App:Post')->findByPage(
            $request->query->getInt('page', 1),
            5
        );

        $posts = $postRepository->findAllAdvicePost();
        return $this->render('backend/post/advicePostList.html.twig', [
            'posts' => $posts,
            'listPost' => $listPost

        ]);
    }

    // Création d'un article de conseil sur page d'accueil
    /**
     * @Route("/advice-post/new/", name="advicePostNew")
     */
    public function advicePostNew(Request $request, StatusRepository $statusRepository, Slugger $slugger)
    {
        $statusCode = 'UNBLOCKED';
        $statusCode= $statusRepository->findOneByCode($statusCode);
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        

        
        if ($form->isSubmitted() && $form->isValid()) {

            $post->setType('Article');
            $post->setStatus($statusCode);

            $slug = $slugger->slugify($post->getTitle());
            $post->setSlug($slug);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager -> persist($post);
            $entityManager -> flush();


       


            $this->addFlash(
                'success',
                'Votre article a bien été enregistré !'
            );

            
         

            return $this->redirectToRoute('backend_advicePostList');
        }

         
        return $this->render('backend/post/advicePostNew.html.twig', [
            'form' => $form->createView(),
        ]);

       
    }


    /**
     * @Route("/post/edit/{slug}", name="advicePostEdit", methods="GET|POST")
     */
    public function advicePostEdit(Request $request, Post $post)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Article modifié.');
            return $this->redirectToRoute('backend_advicePostEdit', ['slug' => $post->getSlug()]);
        }
        return $this->render('backend/post/advicePostEdit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/post/advicepost/delete/{slug}", name="advicePostDelete", methods="DELETE")
     */
    public function advicePostDelete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
            $this->addFlash('success', 'Article supprimé.');
        }
        return $this->redirectToRoute('backend_advicePostList');
    }

    /**
     * @Route("/post/ad/delete/{slug}", name="adDelete", methods="DELETE")
     */
    public function adDelete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
            $this->addFlash('success', 'Annonce supprimée.');
        }
        return $this->redirectToRoute('backend_adList');
    }


    /**
     * @Route("/{id}/status/{statusCode}", name="post_update_status", methods={"PATCH"})
     */
    public function updateStatus(Request $request, Post $post, StatusRepository $statusRepository): JsonResponse
    {

        $statusCode = $request->get("statusCode");
        $newStatus = $statusRepository->findOneBy(['code' => $statusCode]);

        // 1 - On récupère le statusId fourni via l'url de la requête (Request)
        $post = $post->setStatus($newStatus);
        //On met à jour en base
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        //On construit manuellement la réponse envoyée au navigateur (pas réussi à utiliser le module sérializer pour transformer un objet en Json)
        $toReturn = [
            'id' => $post->getId(),
            'type' => $post->getType(),
            'user' => $post->getUser(),
        ];
        //On construit une réponse json grâce à notre tableau fait-main toReturn
        $response = new JsonResponse($toReturn);
        //On l'envoie au navigateur, on peut les voir dans Network du devtool
        return $response;
    }
}
