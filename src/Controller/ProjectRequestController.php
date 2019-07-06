<?php

namespace App\Controller;

use App\Entity\ProjectRequest;
use App\Form\ProjectRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Services\Utils\FileManager;


/**
 * @Route("/project/request")
 */
class ProjectRequestController extends AbstractController
{
    /**
     * @Route("/", name="project_request_index", methods={"GET"})
     */
    public function index(): Response
    {
        $projectRequests = $this->getDoctrine()
            ->getRepository(ProjectRequest::class)
            ->findAll();

        return $this->render('project_request/index.html.twig', [
            'project_requests' => $projectRequests,
        ]);
    }

    /**
     * @Route("/new", name="project_request_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $projectRequest = new ProjectRequest();
        $form = $this->createForm(ProjectRequestType::class, $projectRequest);
        $form->handleRequest($request);

        // $form = $this->createFormBuilder($projectRequest)
        //     ->add('title', TextType::class, ['label' => 'Titulo del proyecto'])
        //     ->add('save', SubmitType::class, ['label' => 'Create Project'])
        //     ->getForm();
        

        $data['principal_research'] = false;
        $data['collaborating_researchers'] = array
          (
          array("Lorem 1","1-111-1111","correo@correo.com"),
          array("Lorem 2","1-111-1112","correo@correo.com"),
          array("Lorem 3","1-111-1113","correo@correo.com"),
          );

        if ($form->isSubmitted() && $form->isValid()) {

            var_dump($form);
            die();

            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($projectRequest);
            // $entityManager->flush();

            // return $this->redirectToRoute('project_request_index');
        }

        return $this->render('project_request/new.html.twig', [
            'project_request' => $projectRequest,
            'form' => $form->createView(),
            'no_value' => 'No value',
            'data' => $data
        ]);
    }

    /**
     * @Route("/{id}", name="project_request_show", methods={"GET"})
     */
    public function show(ProjectRequest $projectRequest): Response
    {
        return $this->render('project_request/show.html.twig', [
            'project_request' => $projectRequest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="project_request_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProjectRequest $projectRequest): Response
    {
        $form = $this->createForm(ProjectRequestType::class, $projectRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_request_index', [
                'id' => $projectRequest->getId(),
            ]);
        }

        return $this->render('project_request/edit.html.twig', [
            'project_request' => $projectRequest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="project_request_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProjectRequest $projectRequest): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projectRequest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projectRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('project_request_index');
    }
}
