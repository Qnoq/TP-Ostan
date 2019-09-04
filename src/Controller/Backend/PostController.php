<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @Route("/backend/", name="backend_")
 */
class PostController extends AbstractController
{
    /**
     * @Route("post", name="post")
     */
    public function index()
    {
        return $this->render('backend/post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
}
