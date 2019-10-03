<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Message;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class MainController extends AbstractController
{
   

     /**
     * @Route("/mentions-legales", name="mentions_legales")
     */
    public function legalMentions()
    {
        return $this->render('main/cgu.html.twig', [
        ]);
    }

      /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, ContactNotification $notification)
    {
        $contact = new Contact();

            $form = $this->createForm(ContactType::class, $contact);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $notification->notify($contact);
                return $this->redirectToRoute('advice_post');
            }


        return $this->render('main/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/plan-du-site/", name="plan_du_site")
     */
    public function sitemap()
    {

        return $this->render('main/plan_du_site.html.twig', [
        ]);
    }

    /**
     * @Route("/le-concept/", name="concept")
     */
     public function concept()
     {


         return $this->render('main/concept.html.twig', [
         ]);
     }


}
