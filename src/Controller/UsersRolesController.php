<?php

namespace App\Controller;

use App\Entity\UsersRoles;
use App\Form\UsersRolesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * @Route("/users/roles")
 */
class UsersRolesController extends AbstractController
{
    /**
     * @Route("/", name="users_roles_index", methods={"GET"})
     */
    public function index(ContainerInterface $container): Response
    {
        $this->container = $container;
        $usersRoles = $this->getDoctrine()
            ->getRepository(UsersRoles::class)
            ->findAll();
        
        $entityManager = $this->getDoctrine()->getManager('sip');
        $test = $this->getDoctrine()
            ->getRepository(UsersRoles::class)
            ->getExternalCollaborationByProject($entityManager, 'B0802');
                    
    //var_dump($test);
        return $this->render('users_roles/index.html.twig', [
            'users_roles' => $usersRoles,
        ]);
    }

    /**
     * @Route("/new", name="users_roles_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $usersRole = new UsersRoles();
        $form = $this->createForm(UsersRolesType::class, $usersRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usersRole);
            $entityManager->flush();

            return $this->redirectToRoute('users_roles_index');
        }

        return $this->render('users_roles/new.html.twig', [
            'users_role' => $usersRole,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="users_roles_show", methods={"GET"})
     */
    public function show(UsersRoles $usersRole): Response
    {
        return $this->render('users_roles/show.html.twig', [
            'users_role' => $usersRole,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="users_roles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UsersRoles $usersRole): Response
    {
        $form = $this->createForm(UsersRolesType::class, $usersRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_roles_index', [
                'id' => $usersRole->getId(),
            ]);
        }

        return $this->render('users_roles/edit.html.twig', [
            'users_role' => $usersRole,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="users_roles_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UsersRoles $usersRole): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usersRole->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usersRole);
            $entityManager->flush();
        }

        return $this->redirectToRoute('users_roles_index');
    }
}
