<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;
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


    // attention à l'ordre ! Si id dans la route et que la methode d'apres n'en a pas, n'ira pas la lire !
    /**
     * @Route("/message/new", name="newmessage")
     */
    public function new(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // récupérer l'utilisateur actuel
            $user =$this->getUser();

            // attribuer au message l'auteur du nouveau message
            $message->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager -> flush();
            return $this->redirectToRoute('showmessage', ['title' => $message->getTitle()]);
        }

        return $this->render('message/newmessage.html.twig', [
            'message' => $message,
            'form' => $form->createView() 
        ]);
        
    }

    // afficher le détail d'un message
    /**
     * @Route("/message/{title}", name="showmessage")
     */
    public function show($title,MessageRepository $messageRepository)
    {
        $messages = $messageRepository->findByTitle($title);
        // foreach pour traiter la donnée array récupérée => le getTitle, ds le render, sur un message à chaque fois
        foreach($messages as $message){
            $message;
        }

        return $this->render('message/showmessage.html.twig', [
            'title' => $message->getTitle(),
            'message' => $message,
            'messages' =>$messages,

        ]);
    }
}
