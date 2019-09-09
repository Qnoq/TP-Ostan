<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     *
     * Page de profil
     *
     * @Route("/profil/{id}", name="user_show", methods ={"GET"}, requirements={"id"="\d+"})
     */
    public function show(User $user)
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

        /**
     * Modification d'un user :
     *
     * @Route("/profil/edit/{id}", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encode)
    {
        // Je récupère l'ancien mot de passe :
        $oldPassword = $user->getPassword();

        $form = $this->createForm(UserType::class, $user);

        // Met à jour l'objet User avec les nouvelles valeurs
        // Si l'objet User n'a pas eu de nouveau mot de passe alors le champ "mot de passe" est vide et conserve donc l'ancien mot de passe
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /*
                Si je ne souhaite pas modifier le mot de passe en édition, alors je peux avoir le comportement suivant : mot de passe laissé vide si inchangé.
                Ainsi je dois tester di le nouveau mot de passe est vide, et si c'est le cas je récupère l'ancien mot de passe
            */

            // Si le mot de passe est nul
            if(is_null($user->getPassword())){

                // Le mot de passe encodé est l'ancien mot de passe
                $encodedPassword = $oldPassword;

            // Sinon
            } else {

                // Comme dans la fonction new
                $encodedPassword = $encode->encodePassword($user, $user->getPassword());
                $user->getPassword();

            }

            // Comme dans la fonction new
            $user->setPassword($encodedPassword);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'info',
                'Modification effectuée !'
            );

            return $this->redirectToRoute('user_show', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Suppression d'un user :
     *
     * @Route("/profil/delete/{id}", name="user_delete", methods={"DELETE","POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, User $user)
    {

        // Je dois d'abord effacer la session pour supprimer le user avec lequel je suis connecté :
        $session = $this->get('session');
        $session = new Session();
        $session->invalidate();

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash(
                'danger',
                'Suppression effectuée !'
            );

        }
        return $this->redirectToRoute('advice_post');
    }
}