<?php

namespace App\Controller\Backend;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @Route("/backend/", name="backend_")
 */
class PostController extends AbstractController
{
    /**
     * @Route("", name="adList")
     */
    public function adList(PostRepository $postRepository)
    {
        $adPosts= $postRepository->findAllAdPost();
        return $this->render('backend/post/adList.html.twig', [
            'adPosts' => $adPosts           
        ]);
    }

    /**
     * @Route("articles", name="advicePostList")
     */
    public function advicePostList(PostRepository $postRepository)
    {
        $advicePosts= $postRepository->findAllAdvicePost();
        return $this->render('backend/post/advicePostList.html.twig', [
            'advicePosts' => $advicePosts
           
        ]);
    }

    

    
}
