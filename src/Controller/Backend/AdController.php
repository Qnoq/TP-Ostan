<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @Route("/backend/", name="backend_")
 */
class AdController extends AbstractController
{
    /**
     * @Route("ad", name="ad")
     */
    public function index()
    {
        return $this->render('backend/ad/index.html.twig', [
            'controller_name' => 'AdController',
        ]);
    }
}
