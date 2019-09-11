<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function index(MessageRepository $messageRepository)
    {
        $messages = $messageRepository->findAll();

        return $this->render('message/index.html.twig', [
            'messages' => $messages
        ]);
    }
}
