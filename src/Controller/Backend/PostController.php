<?php

namespace App\Controller\Backend;


use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\StatusRepository;
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
     * @Route("/", name="adList")
     */
    public function adList(PostRepository $postRepository)
    {
        $posts = $postRepository->findAllAdPost();
        return $this->render('backend/post/adList.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/articles", name="advicePostList")
     */
    public function advicePostList(PostRepository $postRepository)
    {
        $posts = $postRepository->findAllAdvicePost();
        return $this->render('backend/post/advicePostList.html.twig', [
            'posts' => $posts

        ]);
    }

    // Création d'un article de conseil sur page d'accueil
    /**
     * @Route("/advice-post/new/", name="advicePostNew")
     */
    public function advicePostNew(Request $request, StatusRepository $statusRepository)
    {
        $statusCode = 'UNBLOCKED';
        $statusCode= $statusRepository->findOneByCode($statusCode);
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {

            $post->setType('Article');
            $post->setStatus($statusCode);
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
     * @Route("/post/advicepost/delete/{id}", name="advicePostDelete", methods="DELETE", requirements={"id"="\d+"})
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
     * @Route("/post/ad/delete/{id}", name="adDelete", methods="DELETE", requirements={"id"="\d+"})
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
     * @Route("/{id}/status/{statusCode}", name="post_update_status", methods={"PATCH"}, requirements={"id"="\d+"})
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
