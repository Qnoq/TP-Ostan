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
     * @Route("user", name="userList")
     */
    public function userList()
    {
        return $this->render('backend/user/userList.html.twig', [
           
        ]);
    }
}
