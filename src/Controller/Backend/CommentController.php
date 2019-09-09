<?php

namespace App\Controller\Backend;

use App\Entity\Comment;
use App\Repository\StatusRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * 
 * @Route("/backend/", name="backend_")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("comment", name="comment")
     */
    public function index()
    {
        return $this->render('backend/comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }


    // Bloquer un commentaire
    /**
     * @Route("/post/comment/{id}", name="comment_block", requirements={"id"="\d+"})
     */
    public function blockComment(Comment $comment, StatusRepository $statusRepository)
    {
        $code = "BLOCKED";
        $blockedStatus = $statusRepository->findOneByCode($code);
        $comment->setStatus($blockedStatus);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();
        return $this->redirectToRoute('ad_post_show');
    }


     // Débloquer un commentaire
    /**
     * @Route("/post/comment/{id}", name="comment_unblock", requirements={"id"="\d+"})
     */
    public function unblockComment(Comment $comment, StatusRepository $statusRepository)
    {
        $code = "UNBLOCKED";
        $unblockedStatus = $statusRepository->findOneByCode($code);
        $comment->setStatus($unblockedStatus);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();
        return $this->redirectToRoute('ad_post_show');
    }
}
