<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @Route("/backend/", name="backend_")
 */
class AdvicePostController extends AbstractController
{
    /**
     * @Route("advice/post", name="advice_post")
     */
    public function index()
    {
        return $this->render('backend/advice_post/index.html.twig', [
            'controller_name' => 'AdvicePostController',
        ]);
    }
}
