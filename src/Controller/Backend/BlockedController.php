<?php

namespace App\Controller\Backend;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @Route("/backend/", name="backend_")
 */
class BlockedController extends AbstractController
{
    /**
     * @Route("blocked", name="blocked_index")
     */
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->findAll();
        return $this->render('backend/blocked/index.html.twig', [
            'posts' => $posts,
            
        ]);
    }
}
