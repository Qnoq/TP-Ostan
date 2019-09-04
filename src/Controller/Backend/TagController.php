<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @Route("/backend/", name="backend_")
 */
class TagController extends AbstractController
{
    /**
     * @Route("tag", name="tag")
     */
    public function index()
    {
        return $this->render('backend/tag/index.html.twig', [
            'controller_name' => 'TagController',
        ]);
    }
}
