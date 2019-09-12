<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Repository\StatusRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Session\Session;



/**
 *
 * @Route("/backend/", name="backend_")
 */
class UserController extends AbstractController
{


    /**
     * @Route("user", name="userList")
     */
    public function userList(UserRepository $userRepository, RoleRepository $roleRepository, Request $request)
    {
        $db = $this->getDoctrine()->getManager();

        $listUser = $db->getRepository('App:User')->findByPage(
            $request->query->getInt('page', 1),
            4
        );

        $roles = $roleRepository->findAll();
        $users = $userRepository->findAll();
        return $this->render('backend/user/userList.html.twig', [
            'users' => $users,
            'roles' => $roles,
            'listUser' => $listUser
        ]);
    }

    /**
     * @Route("user/delete/{id}", name="user_delete", methods={"DELETE","POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, User $user): Response
    {

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
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

    /**
     * @Route("user/{id}/role/{roleId}", name="user_edit_role", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function updateRole(Request $request, User $user, RoleRepository $roleRepository): JsonResponse
    {
        // 1 - On récupère le roleId fourni via l'url de la requête (Request)
        $newRoleId = $request->get("roleId");
        //On récupère l'objet en base qui correspond à cet id (à l'id qu'on aura eu avec la requete dans l'url) pour le stocker
        $newRole = $roleRepository->findOneBy(['id' => $newRoleId]);
        // On met à jour le rôle de l'user avec le role précédemment récupéré
        $user = $user->setRole($newRole);
        //On met à jour en base
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        //On construit manuellement la réponse envoyée au navigateur (pas réussi à utiliser le module sérializer pour transformer un objet en Json)
        $toReturn = [
            'id' => $user->getId(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
        ];
        //On construit une réponse json grâce à notre tableau fait-main toReturn
        $response = new JsonResponse($toReturn);
        //On l'envoie au navigateur, on peut les voir dans Network du devtool
        return $response;
    }

    /**
     * @Route("user/{id}/status/{statusCode}", name="user_update_status", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function updateStatus(Request $request, User $user, StatusRepository $statusRepository): JsonResponse
    {
        $statusCode = $request->get("statusCode");
        $newStatus = $statusRepository->findOneBy(['code' => $statusCode]);

        // 1 - On récupère le statusId fourni via l'url de la requête (Request)
        $user = $user->setStatus($newStatus);
        //On met à jour en base
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        //On construit manuellement la réponse envoyée au navigateur (pas réussi à utiliser le module sérializer pour transformer un objet en Json)
        $toReturn = [
            'id' => $user->getId(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
        ];
        //On construit une réponse json grâce à notre tableau fait-main toReturn
        $response = new JsonResponse($toReturn);
        //On l'envoie au navigateur, on peut les voir dans Network du devtool
        return $response;
    }
}
