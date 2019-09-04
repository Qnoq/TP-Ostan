<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
