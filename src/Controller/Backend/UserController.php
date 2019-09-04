<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @Route("/backend/", name="backend_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("user", name="user")
     */
    public function index()
    {
        return $this->render('backend/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
