<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * 
 * @Route("/backend/", name="backend_")
 */
class UserController extends AbstractController
{
   

    /**
     * @Route("user", name="userList")
     */
    public function userList(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        return $this->render('backend/user/userList.html.twig', [
            'users' => $users
           
        ]);
    }

    /**
     * @Route("user/delete/{id}", name="user_delete", methods={"DELETE","POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash(
                'danger',
                'Suppression effectuée'
            );
        }

        return $this->redirectToRoute('backend_userList');
    }

    /**
     * @Route("user/edit/{id}", name="user_edit", requirements={"id"="\d+"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(TagType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Tag modifié.');
            return $this->redirectToRoute('backend_tag_edit', ['id' => $user->getId()]);
        }
        return $this->render('backend/userList.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
}
}
