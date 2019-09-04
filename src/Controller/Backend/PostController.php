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
     * @Route("", name="adList")
     */
    public function adList()
    {
        return $this->render('backend/post/adList.html.twig', [
           
        ]);
    }

    /**
     * @Route("articles", name="advicePostList")
     */
    public function advicePostList()
    {
        return $this->render('backend/post/advicePostList.html.twig', [
           
        ]);
    }

    

    
}
